<?php declare(strict_types = 1);

namespace Modules\LakaNetworkSwitch\Actions;

use API;
use CControllerDashboardWidgetView;
use CControllerResponseData;

class WidgetView extends CControllerDashboardWidgetView {
	private const DEFAULTS = [
		'oper' => 'net.if.status[ifOperStatus.*]',
		'admin' => 'net.if.adminstatus[ifAdminStatus.*]',
		'name' => 'net.if.name[ifName.*]',
		'alias' => 'net.if.alias[ifAlias.*]',
		'speed' => 'net.if.speed[ifHighSpeed.*]',
		'in' => 'net.if.in[ifHCInOctets.*]',
		'out' => 'net.if.out[ifHCOutOctets.*]',
		'errors_in' => 'net.if.in.errors[ifInErrors.*]',
		'errors_out' => 'net.if.out.errors[ifOutErrors.*]',
		'discards_in' => 'net.if.in.discards[ifInDiscards.*]',
		'discards_out' => 'net.if.out.discards[ifOutDiscards.*]',
		'duplex' => 'net.if.duplex[dot3StatsDuplexStatus.*]',
		'iftype' => 'net.if.type[ifType.*]',
		'trunk' => 'vlan.Trunk.Port.Encapsulation[OperType.*]',
		'vlan' => '',
		'poe_status' => '',
		'poe_power' => ''
	];

	protected function doAction(): void {
		$name = trim((string) $this->getInput('name', '')) ?: $this->widget->getDefaultName();
		$data = [
			'name' => $name,
			'devices' => [],
			'truncated' => false,
			'message' => '',
			'can_manage_topology' => $this->getUserType() >= USER_TYPE_ZABBIX_ADMIN,
			'user' => ['debug_mode' => $this->getDebugMode()]
		];
		$hostids = $this->selectedIds('hostids');
		$groupids = $this->selectedIds('groupids');
		if (!$hostids && !$groupids) {
			$data['message'] = _('Select at least one host group or host in the widget configuration.');
			$this->setResponse(new CControllerResponseData($data));
			return;
		}
		$hosts_by_id = [];
		if ($groupids) {
			foreach (API::Host()->get([
				'output' => ['hostid', 'host', 'name', 'status', 'maintenance_status'],
				'selectInterfaces' => ['available', 'error', 'ip', 'dns', 'main'],
				'groupids' => $groupids, 'monitored_hosts' => true, 'sortfield' => 'name'
			]) as $host) $hosts_by_id[(string) $host['hostid']] = $host;
		}
		if ($hostids) {
			foreach (API::Host()->get([
				'output' => ['hostid', 'host', 'name', 'status', 'maintenance_status'],
				'selectInterfaces' => ['available', 'error', 'ip', 'dns', 'main'],
				'hostids' => $hostids, 'sortfield' => 'name'
			]) as $host) $hosts_by_id[(string) $host['hostid']] = $host;
		}
		$hosts = array_values($hosts_by_id);
		usort($hosts, static fn(array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));
		if (count($hosts) > 50) {
			$hosts = array_slice($hosts, 0, 50);
			$data['truncated'] = true;
		}
		if (!$hosts) {
			$data['message'] = _('No monitored or accessible hosts were found.');
			$this->setResponse(new CControllerResponseData($data));
			return;
		}
		$hide_empty = (int) ($this->fields_values['hide_empty_devices'] ?? 0) === 1;
		foreach ($hosts as $host) {
			$device = $this->buildDevice($host);
			if (!$hide_empty || $device['ports']) $data['devices'][] = $device;
		}
		$manual_links = $this->topologyLinks(array_map(
			static fn(array $device): string => (string) $device['host']['hostid'],
			$data['devices']
		));
		[$discovered_links, $endpoints] = $this->discoveredTopology($data['devices']);
		$manual_keys = [];
		foreach ($manual_links as $link) $manual_keys[$this->topologyLinkKey($link)] = true;
		$discovered_links = array_values(array_filter($discovered_links,
			fn(array $link): bool => !isset($manual_keys[$this->topologyLinkKey($link)])));
		$data['topology_links'] = array_merge($manual_links, $discovered_links);
		$data['topology_endpoints'] = $endpoints;
		if (!$data['devices']) $data['message'] = _('No equipment with matching physical interfaces was found.');
		$this->setResponse(new CControllerResponseData($data));
	}

	private function topologyLinks(array $hostids): array {
		if (!$hostids) return [];
		$links = [];
		foreach (API::UserMacro()->get([
			'output' => ['hostmacroid', 'hostid', 'macro', 'value', 'description'],
			'hostids' => $hostids
		]) as $macro) {
			if (preg_match('/^\{\$LAKA\.TOPOLOGY\.LINK:"([a-f0-9]{8,32})"\}$/i',
					(string) $macro['macro'], $match) !== 1) continue;
			$link = json_decode((string) $macro['value'], true);
			if (!is_array($link) || !isset($link['b'], $link['ai'], $link['bi'])) continue;
			$link['id'] = strtolower($match[1]);
			$link['macro_id'] = (string) $macro['hostmacroid'];
			$link['a'] = (string) $macro['hostid'];
			$link['b'] = (string) $link['b'];
			$link['ai'] = (string) $link['ai'];
			$link['bi'] = (string) $link['bi'];
			$link['an'] = trim((string) ($link['an'] ?? ''));
			$link['bn'] = trim((string) ($link['bn'] ?? ''));
			$link['type'] = trim((string) ($link['type'] ?? 'uplink')) ?: 'uplink';
			$link['description'] = trim((string) ($link['description'] ?? ''));
			$link['source'] = 'manual';
			$links[] = $link;
		}
		usort($links, static fn(array $a, array $b): int => strnatcasecmp(
			$a['a'].'-'.$a['an'].'-'.$a['b'].'-'.$a['bn'],
			$b['a'].'-'.$b['an'].'-'.$b['b'].'-'.$b['bn']
		));
		return $links;
	}

	private function discoveredTopology(array $devices): array {
		$aliases = [];
		$hosts = [];
		foreach ($devices as $device) {
			$hostid = (string) $device['host']['hostid'];
			$hosts[$hostid] = $device;
			foreach ([$device['host']['host'] ?? '', $device['host']['name'] ?? ''] as $name) {
				foreach ($this->topologyNameAliases((string) $name) as $alias) $aliases[$alias] = $hostid;
			}
			foreach ($device['host']['interfaces'] ?? [] as $interface) {
				foreach (['ip', 'dns'] as $field) {
					$value = $this->normalizeTopologyName((string) ($interface[$field] ?? ''));
					if ($value !== '') $aliases[$value] = $hostid;
				}
			}
		}

		$links = [];
		$endpoints = [];
		$seen_links = [];
		foreach ($devices as $device) {
			$source = (string) $device['host']['hostid'];
			foreach ($device['topology_neighbors'] ?? [] as $neighbor) {
				$target = '';
				foreach (array_merge(
					$this->topologyNameAliases((string) ($neighbor['name'] ?? '')),
					$this->topologyNameAliases((string) ($neighbor['ip'] ?? ''))
				) as $alias) {
					if (isset($aliases[$alias]) && $aliases[$alias] !== $source) {
						$target = $aliases[$alias];
						break;
					}
				}
				if ($target !== '') {
					$ends = [
						$source.'|'.strtolower((string) $neighbor['local_port']),
						$target.'|'.strtolower((string) $neighbor['remote_port'])
					];
					sort($ends, SORT_STRING);
					$key = implode('<>', $ends);
					if (isset($seen_links[$key])) continue;
					$seen_links[$key] = true;
					$links[] = [
						'id' => substr(sha1('auto|'.$key), 0, 16), 'macro_id' => '',
						'a' => $source, 'b' => $target,
						'ai' => (string) $neighbor['local_port'], 'an' => (string) $neighbor['local_port'],
						'bi' => (string) $neighbor['remote_port'], 'bn' => (string) $neighbor['remote_port'],
						'type' => 'uplink', 'description' => (string) ($neighbor['platform'] ?: $neighbor['description']),
						'protocol' => strtoupper((string) $neighbor['protocol']),
						'source' => strtolower((string) $neighbor['protocol'])
					];
					continue;
				}

				$id = substr(sha1('endpoint|'.$source.'|'.$neighbor['protocol'].'|'.$neighbor['key']), 0, 16);
				$endpoints[$id] = [
					'id' => $id, 'parent' => $source,
					'name' => trim((string) ($neighbor['name'] ?? '')) ?: _('Unknown neighbor'),
					'ip' => (string) ($neighbor['ip'] ?? ''),
					'local_port' => (string) ($neighbor['local_port'] ?? ''),
					'remote_port' => (string) ($neighbor['remote_port'] ?? ''),
					'platform' => (string) ($neighbor['platform'] ?? ''),
					'description' => (string) ($neighbor['description'] ?? ''),
					'software' => (string) ($neighbor['software'] ?? ''),
					'protocol' => strtoupper((string) ($neighbor['protocol'] ?? '')),
					'type' => $this->topologyDeviceType(implode(' ', [
						$neighbor['name'] ?? '', $neighbor['platform'] ?? '',
						$neighbor['description'] ?? '', $neighbor['software'] ?? ''
					])),
					'lastclock' => (int) ($neighbor['lastclock'] ?? 0)
				];
			}
		}
		return [$links, array_values($endpoints)];
	}

	private function topologyLinkKey(array $link): string {
		$ends = [
			(string) ($link['a'] ?? '').'|'.strtolower((string) ($link['an'] ?? $link['ai'] ?? '')),
			(string) ($link['b'] ?? '').'|'.strtolower((string) ($link['bn'] ?? $link['bi'] ?? ''))
		];
		sort($ends, SORT_STRING);
		return implode('<>', $ends);
	}

	private function topologyNeighbors(array $items): array {
		$neighbors = [];
		foreach ($items as $item) {
			$key = (string) $item['key_'];
			$protocol = $metric = $entry = '';
			if (preg_match('/^laka\.topology\.cdp\.(local\.ifname|remote\.name|remote\.address|remote\.port|remote\.platform|remote\.software|native\.vlan)\[([^]]+)\]$/', $key, $match) === 1) {
				$protocol = 'cdp'; $metric = $match[1]; $entry = $match[2];
			}
			elseif (preg_match('/^laka\.topology\.lldp\.(local\.portid|local\.portdesc|remote\.name|remote\.portid|remote\.portdesc|remote\.chassis|remote\.description)\[([^]]+)\]$/', $key, $match) === 1) {
				$protocol = 'lldp'; $metric = $match[1]; $entry = $match[2];
			}
			else continue;
			$id = $protocol.':'.$entry;
			$neighbors[$id] ??= [
				'key' => $entry, 'protocol' => $protocol, 'name' => '', 'ip' => '',
				'local_port' => '', 'remote_port' => '', 'platform' => '',
				'description' => '', 'software' => '', 'vlan' => '', 'lastclock' => 0
			];
			$value = trim((string) ($item['lastvalue'] ?? ''));
			if ($value === '' || preg_match('/^(?:no such|zbx_notsupported|not supported)/i', $value) === 1) continue;
			$map = [
				'local.ifname' => 'local_port', 'local.portid' => 'local_port', 'local.portdesc' => 'local_port',
				'remote.name' => 'name', 'remote.address' => 'ip', 'remote.port' => 'remote_port',
				'remote.portid' => 'remote_port', 'remote.portdesc' => 'remote_port',
				'remote.platform' => 'platform', 'remote.description' => 'description',
				'remote.software' => 'software', 'remote.chassis' => 'chassis', 'native.vlan' => 'vlan'
			];
			$field = $map[$metric] ?? '';
			if ($field !== '' && ($neighbors[$id][$field] ?? '') === '') $neighbors[$id][$field] = $value;
			$neighbors[$id]['lastclock'] = max($neighbors[$id]['lastclock'], (int) ($item['lastclock'] ?? 0));
		}
		foreach ($neighbors as &$neighbor) {
			if ($neighbor['name'] === '') $neighbor['name'] = (string) ($neighbor['chassis'] ?? '');
			$neighbor['ip'] = $this->topologyAddress((string) $neighbor['ip']);
		}
		unset($neighbor);
		return array_values(array_filter($neighbors, static fn(array $neighbor): bool =>
			$neighbor['name'] !== '' || $neighbor['ip'] !== '' || $neighbor['remote_port'] !== ''
		));
	}

	private function topologyNameAliases(string $value): array {
		$value = $this->normalizeTopologyName($value);
		if ($value === '') return [];
		$aliases = [$value];
		if (strpos($value, '.') !== false) $aliases[] = explode('.', $value, 2)[0];
		return array_values(array_unique($aliases));
	}

	private function normalizeTopologyName(string $value): string {
		return strtolower(trim((string) preg_replace('/\s+/', '', $value)));
	}

	private function topologyAddress(string $value): string {
		$value = trim($value);
		if (preg_match('/^(?:[0-9A-Fa-f]{2}[ :.-]){3}[0-9A-Fa-f]{2}$/', $value) === 1) {
			$bytes = preg_split('/[ :.-]+/', $value);
			return implode('.', array_map(static fn(string $byte): int => hexdec($byte), $bytes));
		}
		return $value;
	}

	private function topologyDeviceType(string $value): string {
		$value = strtolower($value);
		foreach ([
			'phone' => '/phone|telefono|sip[0-9]|sep[0-9a-f]{6,}/',
			'access_point' => '/access[ -]?point|wireless|air-?ap|\bap[0-9_-]/',
			'firewall' => '/fortigate|firewall|\basa\b|palo alto|checkpoint/',
			'router' => '/\brouter\b|\bisr[0-9]|\basr[0-9]|mikrotik|routeros/',
			'switch' => '/\bswitch\b|catalyst|nexus|c9[0-9]{3}|sg[0-9]{3}/',
			'camera' => '/camera|camara|dahua|hikvision/',
			'printer' => '/printer|impresora|lexmark|epson|xerox|ricoh|brother|laserjet/',
			'ups' => '/\bups\b|apc smart/',
			'server' => '/server|servidor|windows|linux|vmware|proxmox/'
		] as $type => $regex) if (preg_match($regex, $value) === 1) return $type;
		return 'endpoint';
	}

	private function buildDevice(array $host): array {
		$hostid = (string) $host['hostid'];
		$port_visual_style = (int) ($this->fields_values['port_visual_style'] ?? 1);
		if (!in_array($port_visual_style, [1, 2], true)) $port_visual_style = 1;
		$data = [
			'name' => $host['name'], 'host' => $host,
			'summary' => ['model' => 'N/D', 'uptime' => 'N/D', 'cpu' => null, 'memory' => null, 'location' => 'N/D'],
			'ports' => [],
			'columns' => max(4, min(48, (int) ($this->fields_values['columns'] ?? 24))),
			'layout_mode' => (int) ($this->fields_values['layout_mode'] ?? 0),
			'port_visual_style' => $port_visual_style,
			'show_alias' => (int) ($this->fields_values['show_alias'] ?? 1) === 1,
			'show_utilization' => (int) ($this->fields_values['show_utilization'] ?? 1) === 1,
			'interface_list_default' => (int) ($this->fields_values['interface_list_default'] ?? 1) === 1,
			'interface_list_rows' => max(6, min(48, (int) ($this->fields_values['interface_list_rows'] ?? 24))),
			'show_featured_charts' => (int) ($this->fields_values['show_featured_charts'] ?? 0) === 1,
			'featured_chart_limit' => max(1, min(12, (int) ($this->fields_values['featured_chart_limit'] ?? 4))),
			'featured_chart_period' => [0 => '1h', 1 => '6h', 2 => '12h', 3 => '24h', 4 => '7d']
				[(int) ($this->fields_values['featured_chart_period'] ?? 2)] ?? '12h',
			'featured_chart_height' => max(180, min(320, (int) ($this->fields_values['featured_chart_height'] ?? 200))),
			'show_hardware_health' => (int) ($this->fields_values['show_hardware_health'] ?? 1) === 1,
			'hardware_sensors' => [],
			'topology_neighbors' => [],
			'message' => '', 'user' => ['debug_mode' => $this->getDebugMode()]
		];
		$items = API::Item()->get([
			'output' => ['itemid', 'name', 'key_', 'lastvalue', 'prevvalue', 'lastclock', 'units', 'value_type', 'status', 'state'],
			'hostids' => [$hostid],
			'webitems' => true,
			'filter' => ['status' => 0]
		]);
		$data['summary'] = $this->deviceSummary($items);
		$data['topology_neighbors'] = $this->topologyNeighbors($items);
		$active_triggers = $this->activeTriggers($hostid);
		if ($data['show_hardware_health']) {
			$data['hardware_sensors'] = $this->hardwareSensors($items, $active_triggers);
		}

		$patterns = [];
		foreach (self::DEFAULTS as $metric => $default) {
			$field = match ($metric) {
				'in' => 'traffic_in_pattern', 'out' => 'traffic_out_pattern',
				'errors_in' => 'errors_in_pattern', 'errors_out' => 'errors_out_pattern',
			'discards_in' => 'discards_in_pattern', 'discards_out' => 'discards_out_pattern',
			'iftype' => 'type_pattern',
				default => $metric.'_pattern'
			};
			$patterns[$metric] = $this->wildcardRegex((string) ($this->fields_values[$field] ?? $default));
		}

		$ports = [];
		$item_to_index = [];
		foreach ($items as $item) {
			foreach ($patterns as $metric => $regex) {
				if ($regex !== '' && preg_match($regex, (string) $item['key_'], $match) === 1) {
					$index = (string) $match[1];
					$ports[$index] ??= $this->emptyPort($index);
					$ports[$index][$metric] = $item['lastvalue'];
					$ports[$index][$metric.'_units'] = $item['units'];
					$ports[$index][$metric.'_clock'] = (int) ($item['lastclock'] ?? 0);
					$ports[$index][$metric.'_prev'] = $item['prevvalue'] ?? null;
					$ports[$index][$metric.'_item_name'] = (string) $item['name'];
					$ports[$index][$metric.'_key'] = (string) $item['key_'];
					$ports[$index][$metric.'_itemid'] = (string) $item['itemid'];
					$this->inferIdentity($ports[$index], (string) $item['name']);
					$ports[$index]['itemids'][] = (string) $item['itemid'];
					$item_to_index[(string) $item['itemid']] = $index;
					break;
				}
			}
		}

		$this->addProblems($ports, $item_to_index, $active_triggers);
		$include = trim((string) ($this->fields_values['include_regex'] ?? ''));
		$exclude = trim((string) ($this->fields_values['exclude_regex'] ?? ''));
		foreach ($ports as $index => &$port) {
			$port['name'] = trim((string) ($port['name'] ?? '')) ?: '#'.$index;
			if (!$this->regexMatches($port['name'], $include, true) || $this->regexMatches($port['name'], $exclude, false)) {
				unset($ports[$index]);
				continue;
			}
			$port['type'] = $this->portType($port['name']);
			$port['member'] = $this->stackMember($port['name']);
			$port['status'] = $this->status($port);
			$port['status_inferred'] = $port['status'] === 'up'
				&& (!is_numeric($port['oper']) || (int) $port['oper'] !== 1)
				&& $this->hasRecentTraffic($port);
			$port['utilization'] = $this->utilization($port);
			$port['speed_text'] = $this->formatSpeed($port['speed'] ?? null, (string) ($port['speed_units'] ?? ''));
			$port['in_text'] = $this->formatRate($port['in'] ?? null, (string) ($port['in_units'] ?? ''));
			$port['out_text'] = $this->formatRate($port['out'] ?? null, (string) ($port['out_units'] ?? ''));
			$port['detail_rows'] = $this->detailRows($port);
			$port['hostid'] = $hostid;
			$port['physical_number'] = $this->physicalNumber($port['name']);
		}
		unset($port);

		uasort($ports, fn(array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));
		$data['ports'] = array_values($ports);
		if (!$data['ports']) {
			$data['message'] = _('No physical interfaces matched. Check the item key patterns and interface filters.');
		}
		$data['counts'] = ['up' => 0, 'down' => 0, 'disabled' => 0, 'unknown' => 0, 'problems' => 0];
		foreach ($data['ports'] as $port) {
			$data['counts'][$port['status']]++;
			if ($port['problems']) $data['counts']['problems']++;
		}
		$availability = array_map(static fn(array $interface): int => (int) ($interface['available'] ?? 0), $host['interfaces'] ?? []);
		$data['health'] = $host['maintenance_status'] ? 'maintenance'
			: (in_array(2, $availability, true) ? 'unavailable'
				: (($data['counts']['problems'] ?? 0) > 0 ? 'warning'
					: (in_array(1, $availability, true) ? 'available' : 'unknown')));
		return $data;
	}

	private function selectedIds(string $field): array {
		$value = $this->fields_values[$field] ?? [];
		$ids = [];
		$stack = [$value];
		while ($stack) {
			$current = array_pop($stack);
			if (is_array($current)) {
				foreach ($current as $key => $nested) {
					if (ctype_digit((string) $key) && (int) $key > 0) $ids[] = (string) $key;
					$stack[] = $nested;
				}
			}
			elseif (is_scalar($current) && ctype_digit(trim((string) $current)) && (int) $current > 0) {
				$ids[] = trim((string) $current);
			}
		}
		return array_values(array_unique($ids));
	}

	private function wildcardRegex(string $pattern): string {
		$pattern = trim($pattern);
		if ($pattern === '' || substr_count($pattern, '*') !== 1) {
			return '';
		}
		return '~^'.str_replace('\\*', '([0-9]+)', preg_quote($pattern, '~')).'$~';
	}

	private function deviceSummary(array $items): array {
		$patterns = [
			'model' => (string) ($this->fields_values['model_pattern'] ?? 'system.hw.model'),
			'cpu' => (string) ($this->fields_values['cpu_pattern'] ?? 'system.cpu.util[cpmCPUTotal5minRev.*]'),
			'memory' => (string) ($this->fields_values['memory_pattern'] ?? 'vm.memory.util[vm.memory.util.*]'),
			'location' => 'system.location[sysLocation.0]'
		];
		$uptime_patterns = array_values(array_unique(array_filter([
			'system.net.uptime[sysUpTime.0]', (string) ($this->fields_values['uptime_pattern'] ?? ''),
			'system.hw.uptime[hrSystemUptime.0]',
			'system.uptime[sysUpTime.0]', 'system.uptime[fgSysUpTime.0]'
		])));
		$values = ['model' => [], 'cpu' => [], 'memory' => [], 'location' => []];
		foreach ($items as $item) {
			foreach ($patterns as $metric => $pattern) {
				if ($this->keyMatches((string) $item['key_'], $pattern)) {
					$values[$metric][] = $item['lastvalue'];
				}
			}
		}
		$uptimes = [];
		foreach ($uptime_patterns as $pattern) {
			$matches = [];
			foreach ($items as $item) {
				if ($this->keyMatches((string) $item['key_'], $pattern) && is_numeric($item['lastvalue'])
						&& (float) $item['lastvalue'] > 0 && (int) ($item['lastclock'] ?? 0) >= time() - 86400) {
					$matches[] = (float) $item['lastvalue'];
				}
			}
			if ($matches) {
				$uptimes = $matches;
				break;
			}
		}
		$uptime = $uptimes ? $this->formatDuration(max($uptimes)) : 'N/D';
		return [
			'model' => trim((string) ($values['model'][0] ?? '')) ?: 'N/D',
			'uptime' => $uptime,
			'cpu' => $this->maximumNumeric($values['cpu']),
			'memory' => $this->maximumNumeric($values['memory']),
			'location' => trim((string) ($values['location'][0] ?? '')) ?: 'N/D'
		];
	}

	private function keyMatches(string $key, string $pattern): bool {
		$pattern = trim($pattern);
		if ($pattern === '') return false;
		$regex = '~^'.str_replace('\\*', '.*', preg_quote($pattern, '~')).'$~';
		return preg_match($regex, $key) === 1;
	}

	private function maximumNumeric(array $values): ?float {
		$numeric = array_map('floatval', array_filter($values, 'is_numeric'));
		return $numeric ? max($numeric) : null;
	}

	private function formatDuration(float $seconds): string {
		$seconds = max(0, (int) $seconds);
		$days = intdiv($seconds, 86400);
		$hours = intdiv($seconds % 86400, 3600);
		$minutes = intdiv($seconds % 3600, 60);
		return $days > 0 ? $days.'d '.$hours.'h' : ($hours > 0 ? $hours.'h '.$minutes.'m' : $minutes.'m');
	}

	private function emptyPort(string $index): array {
		return ['index' => $index, 'name' => '', 'alias' => '', 'oper' => null, 'admin' => null,
			'speed' => null, 'in' => null, 'out' => null, 'errors_in' => null, 'errors_out' => null,
			'discards_in' => null, 'discards_out' => null, 'duplex' => null, 'iftype' => null, 'trunk' => null,
			'vlan' => null, 'poe_status' => null, 'poe_power' => null,
			'itemids' => [], 'problems' => []];
	}

	private function inferIdentity(array &$port, string $item_name): void {
		if (preg_match('/^Interface\s+(.+?)\((.*?)\):\s*/i', $item_name, $m) !== 1
				&& preg_match('/^Interface\s+(.+?):\s*/i', $item_name, $m) !== 1) return;
		$candidate = trim((string) $m[1]);
		if ($port['name'] === '' && $candidate !== '') $port['name'] = $candidate;
		if ($port['alias'] === '' && isset($m[2]) && trim((string) $m[2]) !== '') {
			$port['alias'] = trim((string) $m[2]);
		}
	}

	private function activeTriggers(string $hostid): array {
		return API::Trigger()->get([
			'output' => ['triggerid', 'description', 'priority', 'value'],
			'hostids' => [$hostid], 'monitored' => true, 'filter' => ['value' => 1],
			'selectFunctions' => ['itemid']
		]);
	}

	private function addProblems(array &$ports, array $item_to_index, array $triggers): void {
		foreach ($triggers as $trigger) {
			foreach ($trigger['functions'] ?? [] as $function) {
				$index = $item_to_index[(string) ($function['itemid'] ?? '')] ?? null;
				if ($index !== null && isset($ports[$index])) {
					$ports[$index]['problems'][(string) $trigger['triggerid']] = [
						'name' => $trigger['description'], 'severity' => (int) $trigger['priority']
					];
				}
			}
		}
	}

	private function hardwareSensors(array $items, array $triggers): array {
		$patterns = [
			'temperature' => trim((string) ($this->fields_values['temperature_sensor_regex'] ?? '(temperature|temp sensor|hotspot)')),
			'fan' => trim((string) ($this->fields_values['fan_sensor_regex'] ?? '(^|[^a-z])fan([ :_]|$)')),
			'psu' => trim((string) ($this->fields_values['psu_sensor_regex'] ?? '(power supply|psu)')),
			'other' => trim((string) ($this->fields_values['other_sensor_regex'] ?? '(voltage|humidity|power consumption)'))
		];
		$problems = [];
		foreach ($triggers as $trigger) {
			foreach ($trigger['functions'] ?? [] as $function) {
				$itemid = (string) ($function['itemid'] ?? '');
				if ($itemid !== '') $problems[$itemid][] = [
					'name' => (string) $trigger['description'], 'severity' => (int) $trigger['priority']
				];
			}
		}
		$warning = (float) ($this->fields_values['temperature_warning'] ?? 50);
		$critical = (float) ($this->fields_values['temperature_critical'] ?? 60);
		$sensors = [];
		foreach ($items as $item) {
			$text = (string) $item['name'].' '.(string) $item['key_'];
			if (preg_match('/^Interface\s+/i', (string) $item['name']) === 1
					|| str_starts_with((string) $item['key_'], 'net.if.')
					|| preg_match('/SNMP\s+walk\s+(PSUs?|temperature\s+sensors?)/i', (string) $item['name']) === 1) continue;
			$type = null;
			foreach ($patterns as $candidate => $pattern) {
				if ($pattern !== '' && @preg_match('~'.$pattern.'~i', $text) === 1) {
					$type = $candidate;
					break;
				}
			}
			if ($type === null) continue;
			$itemid = (string) $item['itemid'];
			$item_problems = $problems[$itemid] ?? [];
			$health = (int) ($item['lastclock'] ?? 0) < time() - 86400 ? 'unknown' : 'ok';
			if ($item_problems) {
				$severity = max(array_column($item_problems, 'severity'));
				$health = $severity >= 4 ? 'critical' : 'warning';
			}
			elseif ($type === 'temperature' && is_numeric($item['lastvalue'])) {
				$value = (float) $item['lastvalue'];
				$health = $value >= $critical ? 'critical' : ($value >= $warning ? 'warning' : 'ok');
			}
			$sensors[] = [
				'itemid' => $itemid, 'name' => (string) $item['name'], 'key' => (string) $item['key_'],
				'value' => (string) $item['lastvalue'], 'units' => (string) $item['units'],
				'clock' => (int) $item['lastclock'], 'numeric' => in_array((int) $item['value_type'], [0, 3], true),
				'type' => $type, 'health' => $health, 'problems' => $item_problems
			];
			if (count($sensors) >= 32) break;
		}
		return $sensors;
	}

	private function regexMatches(string $value, string $pattern, bool $empty_result): bool {
		if ($pattern === '') return $empty_result;
		$result = @preg_match('~'.$pattern.'~i', $value);
		if ($result === false) return $empty_result;
		return $result === 1;
	}

	private function portType(string $name): string {
		if (preg_match('/^(Te|Twe|Fo|Hu)/i', $name)) return 'uplink';
		if (preg_match('/^[A-Za-z]+\d+\/(\d+)\//', $name, $m) && (int) $m[1] > 0) return 'uplink';
		return 'ethernet';
	}

	private function stackMember(string $name): int {
		return preg_match('/^[A-Za-z]+(\d+)\//', $name, $m) ? max(1, (int) $m[1]) : 1;
	}

	private function physicalNumber(string $name): int {
		return preg_match('/\/(\d+)$/', $name, $match) ? (int) $match[1] : PHP_INT_MAX;
	}

	private function status(array $port): string {
		$admin = is_numeric($port['admin']) ? (int) $port['admin'] : null;
		$oper = is_numeric($port['oper']) ? (int) $port['oper'] : null;
		if ($admin === 2) return 'disabled';
		if ($oper === 1) return 'up';
		if ($admin === 1 && $oper !== null) return 'down';
		if ($oper !== null) return 'down';
		if ($this->hasRecentTraffic($port)) return 'up';
		return 'unknown';
	}

	private function hasRecentTraffic(array $port): bool {
		$minimum_clock = time() - 600;
		foreach (['in', 'out'] as $metric) {
			$value = $port[$metric] ?? null;
			$clock = (int) ($port[$metric.'_clock'] ?? 0);
			if (is_numeric($value) && (float) $value > 0 && $clock >= $minimum_clock) return true;
		}
		return false;
	}

	private function utilization(array $port): ?float {
		$speed = is_numeric($port['speed']) ? (float) $port['speed'] : 0.0;
		if ($speed <= 0) return null;
		$units = strtolower((string) ($port['speed_units'] ?? ''));
		$speed_bps = str_contains($units, 'bps') ? $speed : $speed * 1000000;
		$in = is_numeric($port['in']) ? (float) $port['in'] : 0.0;
		$out = is_numeric($port['out']) ? (float) $port['out'] : 0.0;
		return min(100.0, max(0.0, max($in, $out) / $speed_bps * 100.0));
	}

	private function formatSpeed(mixed $value, string $units): string {
		if (!is_numeric($value) || (float) $value <= 0) return 'n/a';
		$bps = str_contains(strtolower($units), 'bps') ? (float) $value : (float) $value * 1000000;
		return $this->humanRate($bps);
	}

	private function formatRate(mixed $value, string $units): string {
		if (!is_numeric($value)) return 'n/a';
		$bps = (float) $value;
		if (preg_match('/(^|[^b])B\/s/i', $units)) $bps *= 8;
		return $this->humanRate($bps);
	}

	private function humanRate(float $bps): string {
		foreach ([1000000000000 => 'Tbps', 1000000000 => 'Gbps', 1000000 => 'Mbps', 1000 => 'Kbps'] as $n => $label) {
			if ($bps >= $n) return number_format($bps / $n, $bps / $n >= 10 ? 0 : 1).' '.$label;
		}
		return number_format($bps, 0).' bps';
	}

	private function detailRows(array $port): array {
		$definitions = [
			'in' => _('Bits received'), 'out' => _('Bits sent'), 'oper' => _('Operational status'),
			'speed' => _('Speed'), 'duplex' => _('Duplex status'), 'errors_in' => _('Inbound errors'),
			'errors_out' => _('Outbound errors'), 'discards_in' => _('Inbound packets discarded'),
			'discards_out' => _('Outbound packets discarded'), 'iftype' => _('Interface type'),
			'trunk' => _('Trunk/VLAN type'), 'vlan' => _('Access VLAN'),
			'poe_status' => _('PoE status'), 'poe_power' => _('PoE power')
		];
		$rows = [];
		foreach ($definitions as $metric => $label) {
			if (!array_key_exists($metric, $port) || $port[$metric] === null || $port[$metric] === '') continue;
			$units = (string) ($port[$metric.'_units'] ?? '');
			$value = $this->formatMetricValue($metric, $port[$metric], $units);
			$previous = $port[$metric.'_prev'] ?? null;
			$change = '—';
			if (is_numeric($port[$metric]) && is_numeric($previous)) {
				$delta = (float) $port[$metric] - (float) $previous;
				$change = in_array($metric, ['in', 'out', 'speed'], true)
					? (($delta >= 0 ? '+' : '-').$this->formatRate(abs($delta), $units))
					: (($delta >= 0 ? '+' : '').number_format($delta, 2));
			}
			$rows[] = [
				'name' => $label,
				'item_name' => (string) ($port[$metric.'_item_name'] ?? ''),
				'clock' => (int) ($port[$metric.'_clock'] ?? 0),
				'value' => $value,
				'change' => $change
			];
		}
		return $rows;
	}

	private function formatMetricValue(string $metric, mixed $value, string $units): string {
		if ($metric === 'in' || $metric === 'out') return $this->formatRate($value, $units);
		if ($metric === 'speed') return $this->formatSpeed($value, $units);
		if ($metric === 'poe_power' && is_numeric($value)) return number_format((float) $value, 2).' '.$units;
		if ($metric === 'oper') {
			return [1 => 'UP (1)', 2 => 'DOWN (2)', 3 => 'testing (3)', 4 => 'unknown (4)',
				5 => 'dormant (5)', 6 => 'notPresent (6)', 7 => 'lowerLayerDown (7)'][(int) $value] ?? (string) $value;
		}
		if ($metric === 'duplex') {
			return [1 => 'unknown (1)', 2 => 'halfDuplex (2)', 3 => 'fullDuplex (3)'][(int) $value] ?? (string) $value;
		}
		if ($metric === 'iftype') {
			return [6 => 'ethernetCsmacd (6)', 24 => 'softwareLoopback (24)', 53 => 'propVirtual (53)',
				117 => 'gigabitEthernet (117)', 161 => 'ieee8023adLag (161)'][(int) $value] ?? (string) $value;
		}
		if ($metric === 'trunk') {
			return [1 => 'other (1)', 2 => 'isl (2)', 3 => 'dot10 (3)', 4 => 'dot1Q (4)', 5 => 'lane (5)',
				6 => 'negotiate (6)'][(int) $value] ?? (string) $value;
		}
		return is_numeric($value) ? number_format((float) $value, 2) : (string) $value;
	}
}
