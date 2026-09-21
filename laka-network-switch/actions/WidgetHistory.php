<?php declare(strict_types = 1);

namespace Modules\LakaNetworkSwitch\Actions;

use API;
use CController;
use CControllerResponseData;

class WidgetHistory extends CController {
	private const PERIODS = [
		'1h' => 3600,
		'6h' => 21600,
		'12h' => 43200,
		'24h' => 86400,
		'7d' => 604800
	];

	protected function init(): void {
		$this->disableCsrfValidation();
	}

	protected function checkInput(): bool {
		return $this->validateInput([
			'hostid' => 'required|int32',
			'in_itemid' => 'id',
			'out_itemid' => 'id',
			'period' => 'string'
		]);
	}

	protected function checkPermissions(): bool {
		return $this->getUserType() >= USER_TYPE_ZABBIX_USER;
	}

	protected function doAction(): void {
		try {
			$hostid = (string) $this->getInput('hostid');
			$period = (string) $this->getInput('period', '12h');
			if (!array_key_exists($period, self::PERIODS)) $period = '12h';
			$time_till = time();
			$time_from = $time_till - self::PERIODS[$period];
		$itemids = array_values(array_unique(array_filter([
			(string) $this->getInput('in_itemid', ''),
			(string) $this->getInput('out_itemid', '')
		], static fn(string $itemid): bool => $itemid !== '')));

		$items = $itemids ? API::Item()->get([
			'output' => ['itemid', 'value_type', 'units'],
			'itemids' => $itemids,
			'hostids' => [$hostid],
			'filter' => ['status' => 0]
		]) : [];
		$items_by_id = [];
		foreach ($items as $item) $items_by_id[(string) $item['itemid']] = $item;

		$payload = ['in' => [], 'out' => [], 'units' => 'bps', 'period' => $period,
			'time_from' => $time_from, 'time_till' => $time_till];
		foreach (['in' => (string) $this->getInput('in_itemid', ''),
			'out' => (string) $this->getInput('out_itemid', '')] as $direction => $itemid) {
			$item = $items_by_id[$itemid] ?? null;
			if ($item === null || !in_array((int) $item['value_type'], [0, 3], true)) continue;
			$payload['units'] = (string) $item['units'] ?: $payload['units'];
			if ($period === '7d') {
				$history = API::Trend()->get([
					'output' => ['clock', 'value_avg'],
					'itemids' => [$itemid],
					'time_from' => $time_from,
					'time_till' => $time_till,
					'sortfield' => 'clock',
					'sortorder' => 'DESC',
					'limit' => 300
				]);
				$history = array_map(static fn(array $point): array => [
					'clock' => $point['clock'], 'value' => $point['value_avg']
				], $history);
			}
			else {
				$history = API::History()->get([
					'output' => ['clock', 'value'],
					'itemids' => [$itemid],
					'history' => (int) $item['value_type'],
					'time_from' => $time_from,
					'time_till' => $time_till,
					'sortfield' => 'clock',
					'sortorder' => 'DESC',
					'limit' => 10000
				]);
			}
			foreach ($this->downsample(array_reverse($history), 300) as $point) {
				$payload[$direction][] = [(int) $point['clock'], (float) $point['value']];
			}
		}

			$this->respond(true, $payload);
		}
		catch (\Throwable $exception) {
			$this->respond(false, [], $exception->getMessage());
		}
	}

	private function respond(bool $ok, array $payload = [], string $error = ''): void {
		$this->setResponse((new CControllerResponseData([
			'main_block' => json_encode(['ok' => $ok, 'data' => $payload, 'error' => $error])
		]))->disableView());
	}

	private function downsample(array $points, int $limit): array {
		if (count($points) <= $limit) return $points;
		$step = (count($points) - 1) / ($limit - 1);
		$result = [];
		for ($index = 0; $index < $limit; $index++) {
			$result[] = $points[(int) round($index * $step)];
		}
		return $result;
	}
}
