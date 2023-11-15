<?php
declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\Table\ApplicationsTable;
use Rhino\Fields\Field;

class Select extends Field {
	public function loadOptions() {
		$Apps = new ApplicationsTable();
		$tables = $this->prepareSelect($Apps->getList());
		return ['tables' => $tables];
	}

	public function load($value) {
		$displayOptions = ['type' => 'select'];
		$selectOptions = [];

		if (!empty($this->options["selectFromTable"])) {
			$selectOptions = $this->getTableOptions();
		} else if (!empty($this->options['selectValues'])) {
			$selectOptions = $this->getSimpleOptions();
		}

		if (isset($this->options['selectEmpty']) && $this->options['selectEmpty']) {
			$selectOptions = $this->addEmptyOption($selectOptions);
		}

		if (isset($this->options['selectMultiple']) && $this->options['selectMultiple']) {
			$displayOptions['multiple'] = true;
			$displayOptions['type'] = 'radio';

			if (!empty($value) || !empty($this->field->standard)) {
				$field['displayOptions']['value'] = explode(',', $value ?? $this->field->standard);
			}
		}

		$displayOptions["options"] = $selectOptions;
		return $displayOptions;
	}

	public function display($value, $entry) {
		if (!empty($this->options["selectFromTable"]) && !empty($value)) {
			$selectOptions = $this->getTableOptions();
		} else if (!empty($this->options['selectValues'])) {
			$selectOptions = $this->getSimpleOptions();
		}

		if (isset($this->options['selectMultiple']) && $this->options['selectMultiple'] && !empty($value)) {
			$values = explode($this->options['selectSeparator'], $value);
			$return = [];
			foreach ($values as $value) {
				$return[] = $selectOptions[$value];
			}

			return join($this->options['selectSeparator'] . ' ', $return);
		}

		return $selectOptions[$value] ?? null;
	}

	public function save($value, $entity) {
		if (isset($this->options['selectMultiple']) && $this->options['selectMultiple'] && !empty($value)) {
			$value = join($this->options['selectSeparator'], $value);
		}
		
		return $value;
	}

	private function getTableOptions() {
		$Table = $this->getTable($this->options["selectFromTable"]);

		$select = [
			'fields' => [
				$this->options["selectFromValue"], 
				$this->options["selectFromAlias"]
			]
		];

		$sql = json_decode($this->options["selectFromSQL"], true);

		// debug(json_encode(['orderBy' => ['position' => 'ASC']]));
		// debug($this->options["selectFromSQL"]);
		// dd($sql);

		if (is_array($sql)) {
			$select = array_merge($select, $sql);
		}

		return $Table->find('list', $select)->toArray();
	}

	private function getSimpleOptions() {
		$return = [];
		$values = preg_split("/\r\n|\n|\r/", $this->options['selectValues']);
		$keys = !empty($keys) ? preg_split("/\r\n|\n|\r/", $this->options['selectKeys']) : [];

		foreach ($values as $key => $value) {
			$key = $keys[$key] ?? $key;
			$return[$key] = $value;
		}

		return $return;
	}
}