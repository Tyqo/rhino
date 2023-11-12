<?php
declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\Table\ApplicationsTable;
use Rhino\Fields\Field;
use Cake\ORM\TableRegistry;

class Select extends Field {
	static public function loadOptions() {
		$Apps = new ApplicationsTable();
		$tables = self::prepareSelect($Apps->getList());
		return ['tables' => $tables];
	}

	static public function loadField($field, $value = null) {
		$options = $field->options;
		$field['displayOptions'] = [];
		
		if (!empty($options["selectFromTable"])) {
			$displayOptions = self::getTableOptions($field->options);
		}

		if (!empty($options['selectValues'])) {
			$displayOptions = self::getSimpleOptions($options);
		}

		if (isset($options['selectEmpty']) && $options['selectEmpty']) {
			$displayOptions = self::addEmptyOption($displayOptions);
		}

		if (isset($options['selectMultiple']) && $options['selectMultiple']) {
			$field['displayOptions']['multiple'] = true;
			$field['displayOptions']['type'] = 'radio';

			if (!empty($value) || !empty($field->standard)) {
				$field['displayOptions']['value'] = explode(',', $value ?? $field->standard);
			}
		}

		$field['displayOptions']["options"] = $displayOptions;
		return $field;
	}

	static public function displayField($value, $field, $entry) {
		$options = $field->options;
		
		if (!empty($options["selectFromTable"]) && !empty($value)) {
			$selectOptions = self::getTableOptions($options);
		}

		if (!empty($options['selectValues'])) {
			$selectOptions = self::getSimpleOptions($options);
		}


		if (isset($options['selectMultiple']) && $options['selectMultiple'] && !empty($value)) {
			$values = explode($options['selectSeparator'], $value);
			$return = [];
			foreach ($values as $value) {
				$return[] = $selectOptions[$value];
			}

			return join($options['selectSeparator'] . ' ', $return);
		}

		return $selectOptions[$value] ?? null;
	}

	static public function saveField($value, $field) {
		$options = $field->options;

		if (isset($options['selectMultiple']) && $options['selectMultiple'] && !empty($value)) {
			$value = join($options['selectSeparator'], $value);
		}
		
		return $value;
	}

	static private function getTableOptions($options) {
		try {
			$Table = TableRegistry::getTableLocator()->get(ucfirst($options["selectFromTable"]));
		} catch (\Throwable $th) {
			$Table = TableRegistry::getTableLocator()->get('Rhino.Tables');
			$Table->setTable($options["selectFromTable"]);
		}

		$select = ['fields' => [$options["selectFromValue"], $options["selectFromAlias"]]];
		$sql = json_decode($options["selectFromSQL"], true);
		if (is_array($sql)) {
			$select = array_merge($select, $sql);
		}

		return $Table->find('list', $select)->toArray();
	}

	static private function getSimpleOptions($options) {
		$return = [];
		$values = preg_split("/\r\n|\n|\r/", $options['selectValues']);
		$keys = !empty($keys) ? preg_split("/\r\n|\n|\r/", $options['selectKeys']) : [];

		foreach ($values as $key => $value) {
			$key = $keys[$key] ?? $key;
			$return[$key] = $value;
		}

		return $return;
	}
}