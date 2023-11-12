<?php
declare(strict_types=1);

namespace Rhino\Handlers;

use Rhino\Model\Table\FieldsTable;

class FieldHandler {
	public $customTypes = [
		[
			"name" => "string",
			"alias" => "String",
		],
		[
			'name' => 'text',
			"alias" => "Text",
		],
		[
			'name' => 'decimal',
			"alias" => "Decimal (float)",
			"type" => 'float'
		],
		[
			'name' => 'integer',
			"alias" => "Number (integer)",
		],
		[
			'name' => 'checkbox',
			"alias" => "Checkbox",
			"type" => "boolean",
		],
		[
			'name' => 'select',
			"alias" => "Select",
			"type" => "string",
		],
		[
			'name' => 'dateTime',
			"alias" => "Date & Time",
			"type" => "datetime",
		],
		[
			'name' => 'date',
			"alias" => "Date",
		],
		[
			'name' => 'time',
			"alias" => "Time",
		],
		[
			'name' => 'color',
			"alias" => "Color",
			"type" => "string",
		],
		[
			'name' => 'position',
			"alias" => "Position",
			"type" => "integer",
		],
		[
			"name" => "upload",
			"alias" => "Upload",
			"type" => "string",
		]
	];

	public function __construct() {
		$this->Fields = new FieldsTable();
	}

	private function executeFieldClass($field, $function, &$params = null) {
		$className = sprintf('\Rhino\Fields\%s', ucfirst($field['name']));
		if (class_exists($className)) {
			return $className::$function($params);
		}
		return;
	}

	public function listColumns(string $tableName): array {
		return array_column($this->Fields->getColumns($tableName), "Field");
	}

	public function getFields(string $tableName) {
		$fields = [];
		$columns = $this->Fields->getColumns($tableName);
		
		foreach ($columns as $column) {
			$name = $column['Field'];
			$fields[$name] = $this->getField($name, $tableName, $column);
		}

		return $fields;
	}

	public function getField($name, $tableName, $column = null) {
		$field = $this->Fields->getByName($name, $tableName, $column);

		// ToDo: Implement LoadFunction for Field Types
		// Will have to move save and load functions to Entity Class

		return $field;
	}

	public function getTypes() {
		return $this->prepareForSelect($this->customTypes);
	}

	private function prepareForSelect($values) {
		// echo '<pre>';
		// var_dump($values);
		// die;
		$selectOptions = [];

		foreach ($values as $key => $value) {
			$type = $value['name'];

			if (isset($value['type'])) {
				$type = $value['type'];
			}

			$selectOptions[$value['name']] = $value['alias'];
		}

		return $selectOptions;
	}

	public function getDatabaseType($type) {
		$types = array_column($this->customTypes, "type", "name");
		
		if (isset($types[$type])) {
			return $types[$type];
		}
		return $type;
	}

	public function getDefaults(string $tableName) {
		$fields = $this->Fields->find()->select(['name', 'standard'])->where(['tableName' => $tableName])->toArray();
		$defaults = [];
		foreach ($fields as $field) {
			if (empty($field['standard'])) {
				continue;
			}

			$defaults[$field['name']] = $field['standard'];
		}
		return $defaults;
	}

	public function setFiledData($data) {
		if (isset($data['default'])) {
			$data['standard'] = $data['default'];
		}

		return $data;
	}

	public function loadFiledOptions() {
		$return = [];
		foreach ($this->customTypes as $key => $type) {
			$loadOptions = $this->executeFieldClass($type, 'loadOptions');
			if (empty($loadOptions)) {
				continue;
			}

			$return += $loadOptions;
		}
		return $return;
	}

	public function loadField($field, $value) {
		$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
		if (class_exists($fieldClass)) {
			$field = $fieldClass::loadField($field, $value);
		}
		return $field;
	}

	public function setFields(string $tableName, $entity) {
		$fields = $this->getFields($tableName);
		
		foreach ($fields as $field) {
			$key = $field['name'];
			$value = $entity[$key] ?? Null;
			$value = $this->setField($value, $field);
			if ($value === null) {
				unset($entity[$key]);
				continue;
			}
			$entity[$key] =	$value;
		}

		// dd($entity);

		return $entity;
	}

	private function setField($value, $field) {
		$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
		if (class_exists($fieldClass)) {
			return $fieldClass::saveField($value, $field);
		}

		return $value;
	}

	public function display($entry, $field) {
		$value = $entry[$field->name] ?? null;
		$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
		if (class_exists($fieldClass)) {
			return $fieldClass::displayField($value, $field, $entry);
		}

		return $value;
	}
}

?>