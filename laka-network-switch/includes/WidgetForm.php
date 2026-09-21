<?php declare(strict_types = 1);

namespace Modules\LakaNetworkSwitch\Includes;

use Zabbix\Widgets\CWidgetForm;
use Zabbix\Widgets\Fields\CWidgetFieldMultiSelectHost;
use Zabbix\Widgets\Fields\CWidgetFieldMultiSelectGroup;
use Zabbix\Widgets\Fields\CWidgetFieldSelect;
use Zabbix\Widgets\Fields\CWidgetFieldTextBox;

class WidgetForm extends CWidgetForm {
	public function addFields(): self {
		$this
			->addField(new CWidgetFieldMultiSelectGroup('groupids', _('Host groups')))
			->addField((new CWidgetFieldMultiSelectHost('hostids', _('Additional or specific hosts')))->setMultiple(true))
			->addField((new CWidgetFieldSelect('layout_mode', _('Port layout'), [
				0 => _('Automatic (recommended)'),
				1 => _('Compact grid'),
				2 => _('Physical odd/even')
			]))->setDefault(0))
			->addField((new CWidgetFieldSelect('port_visual_style', _('Port visual style'), [
				1 => _('Modern compact'), 2 => _('Dashboard tiles')
			]))->setDefault(1))
			->addField((new CWidgetFieldTextBox('columns', _('Ports per row')))->setDefault('24'))
			->addField((new CWidgetFieldSelect('show_alias', _('Show interface alias'), [
				0 => _('No'), 1 => _('Yes')
			]))->setDefault(1))
			->addField((new CWidgetFieldSelect('show_utilization', _('Show utilization percentage'), [
				0 => _('No'), 1 => _('Yes')
			]))->setDefault(1))
			->addField((new CWidgetFieldSelect('interface_list_default', _('Interface list initial state'), [
				0 => _('Collapsed'), 1 => _('Expanded')
			]))->setDefault(1))
			->addField((new CWidgetFieldTextBox('interface_list_rows', _('Visible interface rows')))->setDefault('24'))
			->addField((new CWidgetFieldSelect('hide_empty_devices', _('Hide equipment without matching interfaces'), [
				0 => _('No'), 1 => _('Yes')
			]))->setDefault(0))
			->addField((new CWidgetFieldSelect('show_featured_charts', _('Show featured interface charts'), [
				0 => _('No'), 1 => _('Yes')
			]))->setDefault(0))
			->addField((new CWidgetFieldTextBox('featured_chart_limit', _('Maximum featured interface charts')))
				->setDefault('4'))
			->addField((new CWidgetFieldSelect('featured_chart_period', _('Featured chart default period'), [
				0 => '1h', 1 => '6h', 2 => '12h', 3 => '24h', 4 => '7d'
			]))->setDefault(2))
			->addField((new CWidgetFieldTextBox('featured_chart_height', _('Featured chart height (px)')))
				->setDefault('200'))
			->addField((new CWidgetFieldSelect('show_hardware_health', _('Show hardware health'), [
				0 => _('No'), 1 => _('Yes')
			]))->setDefault(1))
			->addField((new CWidgetFieldTextBox('temperature_sensor_regex', _('Temperature sensor name/key (regex)')))
				->setDefault('(temperature|temp sensor|hotspot)'))
			->addField((new CWidgetFieldTextBox('fan_sensor_regex', _('Fan sensor name/key (regex)')))
				->setDefault('(^|[^a-z])fan([ :_]|$)'))
			->addField((new CWidgetFieldTextBox('psu_sensor_regex', _('PSU sensor name/key (regex)')))
				->setDefault('(power supply|psu)'))
			->addField((new CWidgetFieldTextBox('other_sensor_regex', _('Other hardware sensor name/key (regex)')))
				->setDefault('(voltage|humidity|power consumption)'))
			->addField((new CWidgetFieldTextBox('temperature_warning', _('Temperature warning threshold')))
				->setDefault('50'))
			->addField((new CWidgetFieldTextBox('temperature_critical', _('Temperature critical threshold')))
				->setDefault('60'))
			->addField((new CWidgetFieldTextBox('model_pattern', _('Hardware model key pattern')))
				->setDefault('system.hw.model'))
			->addField((new CWidgetFieldTextBox('uptime_pattern', _('Hardware uptime key pattern')))
				->setDefault('system.net.uptime[sysUpTime.0]'))
			->addField((new CWidgetFieldTextBox('cpu_pattern', _('CPU utilization key pattern')))
				->setDefault('system.cpu.util[cpmCPUTotal5minRev.*]'))
			->addField((new CWidgetFieldTextBox('memory_pattern', _('Memory utilization key pattern')))
				->setDefault('vm.memory.util[vm.memory.util.*]'))
			->addField((new CWidgetFieldTextBox('include_regex', _('Include interface names (regex)')))
				->setDefault('^(Gi|Te|Twe|Fo|Hu|Eth|Fa)'))
			->addField((new CWidgetFieldTextBox('exclude_regex', _('Exclude interface names (regex)')))
				->setDefault('^(Vl|Vlan|Lo|Loopback|Po|Port-channel|Nu|Null|StackPort|AppGigabitEthernet)'))
			->addField((new CWidgetFieldTextBox('oper_pattern', _('Operational status key pattern')))
				->setDefault('net.if.status[ifOperStatus.*]'))
			->addField((new CWidgetFieldTextBox('admin_pattern', _('Administrative status key pattern')))
				->setDefault('net.if.adminstatus[ifAdminStatus.*]'))
			->addField((new CWidgetFieldTextBox('name_pattern', _('Interface name key pattern')))
				->setDefault('net.if.name[ifName.*]'))
			->addField((new CWidgetFieldTextBox('alias_pattern', _('Interface alias key pattern')))
				->setDefault('net.if.alias[ifAlias.*]'))
			->addField((new CWidgetFieldTextBox('speed_pattern', _('Speed key pattern')))
				->setDefault('net.if.speed[ifHighSpeed.*]'))
			->addField((new CWidgetFieldTextBox('traffic_in_pattern', _('Traffic IN key pattern')))
				->setDefault('net.if.in[ifHCInOctets.*]'))
			->addField((new CWidgetFieldTextBox('traffic_out_pattern', _('Traffic OUT key pattern')))
				->setDefault('net.if.out[ifHCOutOctets.*]'))
			->addField((new CWidgetFieldTextBox('errors_in_pattern', _('Errors IN key pattern')))
				->setDefault('net.if.in.errors[ifInErrors.*]'))
			->addField((new CWidgetFieldTextBox('errors_out_pattern', _('Errors OUT key pattern')))
				->setDefault('net.if.out.errors[ifOutErrors.*]'))
			->addField((new CWidgetFieldTextBox('discards_in_pattern', _('Discards IN key pattern')))
				->setDefault('net.if.in.discards[ifInDiscards.*]'))
			->addField((new CWidgetFieldTextBox('discards_out_pattern', _('Discards OUT key pattern')))
				->setDefault('net.if.out.discards[ifOutDiscards.*]'))
			->addField((new CWidgetFieldTextBox('duplex_pattern', _('Duplex key pattern')))
				->setDefault('net.if.duplex[dot3StatsDuplexStatus.*]'))
			->addField((new CWidgetFieldTextBox('type_pattern', _('Interface type key pattern')))
				->setDefault('net.if.type[ifType.*]'))
			->addField((new CWidgetFieldTextBox('trunk_pattern', _('Trunk/VLAN type key pattern')))
				->setDefault('vlan.Trunk.Port.Encapsulation[OperType.*]'))
			->addField((new CWidgetFieldTextBox('vlan_pattern', _('Access VLAN key pattern (optional)')))
				->setDefault(''))
			->addField((new CWidgetFieldTextBox('poe_status_pattern', _('PoE status key pattern (optional)')))
				->setDefault(''))
			->addField((new CWidgetFieldTextBox('poe_power_pattern', _('PoE power key pattern (optional)')))
				->setDefault(''));

		return $this;
	}
}
