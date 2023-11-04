<?php
declare(strict_types=1);

namespace Rhino\Handlers;

use Rhino\Model\Table\FieldsTable;

class FieldHandler {
	public $customTypes = [
		"string" => [
			"alias" => "String",
			"type" => "string",
		],
		"text" => [
			"alias" => "Text",
			"type" => "text",
		],
		"float" => [
			"alias" => "Number (float)",
			"type" => "float",
		],
		"integer" => [
			"alias" => "Number (integer)",
			"type" => "integer",
		],
		"checkbox" => [
			"alias" => "Checkbox",
			"type" => "boolean",
		],
		"select" => [
			"alias" => "Select",
			"type" => "string",
		],
		"upload" => [
			"alias" => "Upload",
			"type" => "string",
		],
		
		// "select" => [
		// 	"alias" => "Select",
		// 	"type" => "string",
		// 	"settings" => [
		// 		'options' => [
		// 			'type' => 'text',
		// 			'description' => 'Komma separated List',
		// 			'default' => ''
		// 		],
		// 		'applications' => [
		// 			'type' => 'select',
		// 			'description' => 'Applications',
		// 			'default' => '',
		// 			'settings' => ['options' => '', 'multiSelect' => false, 'allowEmpty' => false]
		// 		],
		// 		'defaults' => [
		// 			'type' => 'text',
		// 			'description' => 'Default options',
		// 			'default' => ''
		// 		],
		// 		'multiSelect' => [
		// 			'type' => 'checkbox',
		// 			'description' => 'Allows multiple Options',
		// 			'default' => 'checked'
		// 		],
		// 		'allowEmpty' => [
		// 			'type' => 'checkbox',
		// 			'description' => 'Allows an Empty Option',
		// 			'default' => 'checked'
		// 		]
		// 	]
		// ],
	];

	public function __construct() {
		$this->Fields = new FieldsTable();
		$this->types = $this->Fields->types;
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
		// return [
		// 	"Custom Types" => $this->prepareForSelect($this->customTypes),
		// 	"All Types" => $this->prepareForSelect($this->types)
		// ];
	}

	private function prepareForSelect($values) {
		$selectOptions = [];

		foreach ($values as $key => $value) {
			if (is_string($key)) {
				$value =  $key;
			}

			$selectOptions[$value] = $value;
		}

		return $selectOptions;
	}

	public function getDatabaseType($type) {
		if (isset($this->customTypes[$type])) {
			return $this->customTypes[$type]["type"];
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
			$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($key));
			if (class_exists($fieldClass)) {
				$return += $fieldClass::loadOption();
			}
		}
		return $return;
	}

	public function prepareFields($fields) {
		foreach ($fields as $key => $field) {
			$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
			if (class_exists($fieldClass)) {
				$fields[$key] = $fieldClass::prepareField($field);
			}
		}
		return $fields;
	}

	public function setFields(string $tableName, $entity) {
		$fields = $this->getFields($tableName);

		foreach ($fields as $field) {
			$key = $field['name'];
			$value = isset($entity[$key]) ? $entity[$key] : Null;
			$value = $this->setField($field, $value);
			$entity[$key] =	$value;
		}

		return $entity;
	}

	private function setField($field, $value) {
		return $value;
	}

	public function display($field, $value) {
		$fieldClass = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
		if (class_exists($fieldClass)) {
			return $fieldClass::displayField($field, $value);
		}

		return $value;
	}
}

?>