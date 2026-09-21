<?php declare(strict_types = 1);

namespace Modules\LakaNetworkSwitch\Actions;

use API;
use CController;
use CControllerResponseData;

class WidgetTopology extends CController {
	private const MACRO_PREFIX = '{$LAKA.TOPOLOGY.LINK:"';

	protected function checkInput(): bool {
		return $this->validateInput([
			'operation' => 'required|in save,delete',
			'macro_id' => 'id',
			'link_id' => 'string',
			'hostid_a' => 'id',
			'hostid_b' => 'id',
			'port_index_a' => 'string',
			'port_index_b' => 'string',
			'port_name_a' => 'string',
			'port_name_b' => 'string',
			'link_type' => 'string',
			'description' => 'string'
		]);
	}

	protected function checkPermissions(): bool {
		return $this->getUserType() >= USER_TYPE_ZABBIX_ADMIN;
	}

	protected function doAction(): void {
		try {
			if ((string) $this->getInput('operation') === 'delete') {
				$this->deleteLink();
			}
			else {
				$this->saveLink();
			}
		}
		catch (\Throwable $exception) {
			$this->respond(false, [], $exception->getMessage());
		}
	}

	private function saveLink(): void {
		$hostid_a = (string) $this->getInput('hostid_a', '');
		$hostid_b = (string) $this->getInput('hostid_b', '');
		$port_index_a = trim((string) $this->getInput('port_index_a', ''));
		$port_index_b = trim((string) $this->getInput('port_index_b', ''));
		$port_name_a = trim((string) $this->getInput('port_name_a', ''));
		$port_name_b = trim((string) $this->getInput('port_name_b', ''));
		$type = trim((string) $this->getInput('link_type', 'uplink'));
		$description = trim((string) $this->getInput('description', ''));
		$allowed_types = ['uplink', 'trunk', 'wan', 'ha', 'fortilink', 'other'];
		if ($hostid_a === '' || $hostid_b === '' || $hostid_a === $hostid_b) {
			throw new \RuntimeException(_('Select two different equipment.'));
		}
		if ($port_index_a === '' || $port_index_b === '' || $port_name_a === '' || $port_name_b === '') {
			throw new \RuntimeException(_('Select one interface on each equipment.'));
		}
		if (!in_array($type, $allowed_types, true)) $type = 'other';
		$hosts = API::Host()->get([
			'output' => ['hostid'],
			'hostids' => [$hostid_a, $hostid_b],
			'editable' => true
		]);
		if (count($hosts) !== 2) {
			throw new \RuntimeException(_('You do not have permission to modify one of the selected equipment.'));
		}
		$link_id = strtolower(trim((string) $this->getInput('link_id', '')));
		if (preg_match('/^[a-f0-9]{16}$/', $link_id) !== 1) $link_id = bin2hex(random_bytes(8));
		$value = [
			'v' => 1,
			'b' => $hostid_b,
			'ai' => mb_substr($port_index_a, 0, 64),
			'an' => mb_substr($port_name_a, 0, 128),
			'bi' => mb_substr($port_index_b, 0, 64),
			'bn' => mb_substr($port_name_b, 0, 128),
			'type' => $type,
			'description' => mb_substr($description, 0, 255)
		];
		$encoded = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
		if ($encoded === false) throw new \RuntimeException(_('Could not encode the topology link.'));

		$macro_id = (string) $this->getInput('macro_id', '');
		$this->assertNotDuplicate($hostid_a, $hostid_b, $port_index_a, $port_index_b, $macro_id);
		$existing = $macro_id !== '' ? API::UserMacro()->get([
			'output' => ['hostmacroid', 'hostid', 'macro'],
			'hostmacroids' => [$macro_id]
		]) : [];
		$macro_name = self::MACRO_PREFIX.$link_id.'"}';
		if ($existing) {
			$current = $existing[0];
			if (strpos((string) $current['macro'], '{$LAKA.TOPOLOGY.LINK:') !== 0) {
				throw new \RuntimeException(_('The selected macro is not a topology link.'));
			}
			if ((string) $current['hostid'] !== $hostid_a) {
				$result = API::UserMacro()->create([[
					'hostid' => $hostid_a, 'macro' => $macro_name, 'value' => $encoded,
					'description' => 'LAKA manual topology link'
				]]);
				$new_macro_id = (string) ($result['hostmacroids'][0] ?? '');
				if ($new_macro_id === '') {
					throw new \RuntimeException(_('Could not create the topology link on the selected equipment.'));
				}
				API::UserMacro()->delete([$macro_id]);
				$macro_id = $new_macro_id;
			}
			else {
				API::UserMacro()->update([[
					'hostmacroid' => $macro_id, 'macro' => $macro_name, 'value' => $encoded,
					'description' => 'LAKA manual topology link'
				]]);
			}
		}
		else {
			$result = API::UserMacro()->create([[
				'hostid' => $hostid_a, 'macro' => $macro_name, 'value' => $encoded,
				'description' => 'LAKA manual topology link'
			]]);
			$macro_id = (string) ($result['hostmacroids'][0] ?? '');
		}
		$this->respond(true, [[
			'id' => $link_id, 'macro_id' => $macro_id, 'a' => $hostid_a, 'b' => $hostid_b,
			'ai' => $value['ai'], 'an' => $value['an'], 'bi' => $value['bi'], 'bn' => $value['bn'],
			'type' => $type, 'description' => $value['description'], 'source' => 'manual'
		]]);
	}

	private function assertNotDuplicate(string $a, string $b, string $ai, string $bi,
			string $excluded_macro_id = ''): void {
		foreach (API::UserMacro()->get([
			'output' => ['hostmacroid', 'hostid', 'macro', 'value'],
			'hostids' => [$a, $b]
		]) as $macro) {
			if ($excluded_macro_id !== '' && (string) $macro['hostmacroid'] === $excluded_macro_id) continue;
			if (strpos((string) $macro['macro'], '{$LAKA.TOPOLOGY.LINK:') !== 0) continue;
			$link = json_decode((string) $macro['value'], true);
			if (!is_array($link)) continue;
			$ma = (string) $macro['hostid'];
			$mb = (string) ($link['b'] ?? '');
			$mai = (string) ($link['ai'] ?? '');
			$mbi = (string) ($link['bi'] ?? '');
			if (($ma === $a && $mb === $b && $mai === $ai && $mbi === $bi)
					|| ($ma === $b && $mb === $a && $mai === $bi && $mbi === $ai)) {
				throw new \RuntimeException(_('This topology link already exists.'));
			}
		}
	}

	private function deleteLink(): void {
		$macro_id = (string) $this->getInput('macro_id', '');
		if ($macro_id === '') throw new \RuntimeException(_('Topology link identifier is missing.'));
		$macros = API::UserMacro()->get([
			'output' => ['hostmacroid', 'macro'],
			'hostmacroids' => [$macro_id]
		]);
		if (!$macros || strpos((string) $macros[0]['macro'], '{$LAKA.TOPOLOGY.LINK:') !== 0) {
			throw new \RuntimeException(_('Topology link was not found.'));
		}
		API::UserMacro()->delete([$macro_id]);
		$this->respond(true, [['macro_id' => $macro_id]]);
	}

	private function respond(bool $ok, array $payload = [], string $error = ''): void {
		$this->setResponse((new CControllerResponseData([
			'main_block' => json_encode(['ok' => $ok, 'data' => $payload, 'error' => $error])
		]))->disableView());
	}
}
