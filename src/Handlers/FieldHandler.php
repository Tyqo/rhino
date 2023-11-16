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

	/**
	 * getFieldClass
	 *
	 * Get the Class for the field.
	 * 
	 * @param  object $field
	 * @return \Fields\Field
	 */
	private function getFieldClass($field) {
		$className = sprintf('\Rhino\Fields\%s', ucfirst($field->type));
		if (class_exists($className)) {
			return new $className($field);
		}
		return;
	}

	public function listColumns(string $tableName): array {
		return array_column($this->Fields->getColumns($tableName), "Field");
	}

	public function getFields(string $tableName, ?array $config = null) {
		$fields = [];
		$columns = $this->Fields->getColumns($tableName);
		
		foreach ($columns as $column) {
			$name = $column['Field'];
			$field = $this->getField($name, $tableName, $column);
			if (isset($config) && in_array($name, array_keys($config))) {
				$fieldConfig = $config[$name];
				$field->type = $fieldConfig['type'];
				$field->setOptions($fieldConfig['options']);
			}
			$fields[$name] = $field;
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

	// Todo: Check for Delete
	public function setFiledData($data) {
		if (isset($data['default'])) {
			$data['standard'] = $data['default'];
		}

		return $data;
	}

	/**
	 * loadFiledOptions
	 * 
	 * Load additional Options needed for Field Settings.
	 *
	 * @return array
	 */
	public function loadFiledOptions() {
		$return = [];
		foreach ($this->customTypes as $type) {
			$type['type'] = $type['name'];
			
			$Field = $this->getFieldClass((object)$type);	
			if (isset($Field) && method_exists($Field, 'loadOptions')) {
				$return += $Field->loadOptions() ?? [];
			}
		}

		return $return;
	}

	/**
	 * loadField
	 * 
	 * Load the needed options for the Form->control from its Field Class
	 *
	 * @param  object $field
	 * @param  mixed $value
	 * @return array
	 */
	public function loadField($field, $value) {
		$Field = $this->getFieldClass($field);
		$displayOptions = [];

		if ($Field) {
			$displayOptions = $Field->load($value);
		}
		
		return $displayOptions;
	}

	public function setFields(string $tableName, $entity) {
		$fields = $this->getFields($tableName);
		
		foreach ($fields as $field) {
			$key = $field['name'];
			$value = $this->setField($entity, $field);
			if ($value === null) {
				unset($entity[$key]);
				continue;
			}
			$entity[$key] =	$value;
		}

		return $entity;
	}

	private function setField($entity, $field) {
		if ($field->name == 'filename') {
			$field->type = 'upload';
		}
		$Field = $this->getFieldClass($field);
		$value = $entity[$field['name']] ?? null;

		if ($Field && method_exists($Field, 'save')) {
			return $Field->save($value, $entity);
		}

		return $value;
	}

	/**
	 * display
	 * 
	 * Gets the Html output to display a Field form its Field Class.
	 *
	 * @param  object $entry
	 * @param  object $field
	 * @return ?string
	 */
	public function displayField($entry, $field) {
		$value = $entry[$field->name] ?? null;

		$Field = $this->getFieldClass($field);
		if ($Field) {
			return $Field->display($value, $entry);
		}

		return $value;
	}
}

?>