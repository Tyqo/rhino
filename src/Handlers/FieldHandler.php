<?php
declare(strict_types=1);

namespace Tusk\Handlers;

use Tusk\Model\Table\FieldsTable;

class FieldHandler {
	public $customTypes = [
		"upload" => [
			"alias" => "Upload",
			"type" => "string",
			"settings" => [
				'destination' => [
					'type' => 'string',
					'description' => 'Set the Upload Destination',
					'default' => 'media'
				] 
			]
		],
		"checkbox" => [
			"alias" => "Checkbox",
			"type" => "boolean",
			"settings" => [
				'defaults' => [
					'type' => 'text',
					'description' => 'Default options',
					'default' => 1
				],
			]
		],
		"select" => [
			"alias" => "Select",
			"type" => "string",
			"settings" => [
				'options' => [
					'type' => 'text',
					'description' => 'Komma separated List',
					'default' => ''
				],
				'applications' => [
					'type' => 'select',
					'description' => 'Applications',
					'default' => '',
					'settings' => ['options' => '', 'multiSelect' => false, 'allowEmpty' => false]
				],
				'defaults' => [
					'type' => 'text',
					'description' => 'Default options',
					'default' => ''
				],
				'multiSelect' => [
					'type' => 'checkbox',
					'description' => 'Allows multiple Options',
					'default' => 'checked'
				],
				'allowEmpty' => [
					'type' => 'checkbox',
					'description' => 'Allows an Empty Option',
					'default' => 'checked'
				]
			]
		],
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
		return [
			"Custom Types" => $this->prepareForSelect($this->customTypes),
			"All Types" => $this->prepareForSelect($this->types)
		];
	}

	public function getSettings($type) {
		if (isset($this->customTypes[$type])) {
			return $this->customTypes[$type]['settings'];
		}

		return null;
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
		$fields = $this->Fields->find()->select(['name', 'standart'])->where(['tableName' => $tableName])->toArray();
		$defaults = [];
		foreach ($fields as $field) {
			if (empty($field['standart'])) {
				continue;
			}

			$defaults[$field['name']] = $field['standart'];
		}
		return $defaults;
	}

	public function setFiledData($data) {
		$settings = [];
		$_settings = $this->getSettings($data['type']);
		
		if (isset($_settings)) {
			foreach (array_keys($_settings) as $setting) {
				if (isset($data[$setting])) {
					$settings[$setting] = $data[$setting];
					unset($data[$setting]);
				}
			}
		}
		$data['settings'] = json_encode($settings);

		if (isset($data['default'])) {
			$data['standart'] = $data['default'];
		}

		return $data;
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
		$saveFunction = 'save' . $field['type'];
		if (!empty($field['settings'])) {
			$field['settings'] = json_decode($field['settings'], true);
		}
		if (method_exists($this, $saveFunction)) {
			$value = $this->$saveFunction($value, $field);
		}

		return $value;
	}

	private function saveCheckbox($value, $field) : int {
		if (!empty($value)) {
			$value = 1;
		} else {
			$value = 0;
		}

		return $value;
	}

	private function saveUpload($value, $field) : string {
		if (!is_string($value)) {
			$fileObject = $value;
			$value = $fileObject->getClientFilename();
			$destination = $field['settings']['destination'] . DS . $value;
			$fileObject->moveTo($destination);
		}

		return $value;
	}

	private function saveSelect($value, $field): string {
		if (!empty($field['settings']['multiSelect'])) {
			return implode(', ', $value);
		}

		return $value;
	}
}

?>