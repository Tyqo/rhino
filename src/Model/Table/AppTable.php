<?php

declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
	}

	public function moveUp($entry, $field) {
		$entries = $this->find('all')->select(['id', $field])->orderBy([$field => 'ASC'])->toArray();
		$option = 0;
		$index = null;

		foreach ($entries as $key => $e) {
			$entries[$key][$field] = ++$option;
			if ($e->id == $entry->id) {
				$index = $key;
			}
		}
		
		if ($entries[$index][$field] - 1 != 0) {
			$entries[$index][$field] -= 1;
			$entries[$index - 1][$field] += 1;
		}

		return $this->saveMany($entries);
	}
	
	public function moveDown($entry, $field) {
		$entries = $this->find('all')->select(['id', $field])->orderBy([$field => 'ASC'])->toArray();
		$option = 0;
		$index = null;

		foreach ($entries as $key => $e) {
			$entries[$key][$field] = ++$option;
			if ($e->id == $entry->id) {
				$index = $key;
			}
		}

		if ($entries[$index][$field] != count($entries)) {
			$entries[$index][$field] += 1;
			$entries[$index + 1][$field] -= 1;
		}

		return $this->saveMany($entries);
	}
}
