<?php

namespace Tusk\View\Helper;

use Cake\View\Helper;
use Tusk\Handlers\FieldHandler;
use Cake\View\Exception\MissingElementException;

class FieldsHelper extends Helper {

	public function initialize(array $config): void {
		$this->FieldHandler = new FieldHandler();
	}

	public function render($fields, $values, $options = []) {
		$content = '';

		foreach ($fields as $field) {
			$name = $field['name'];
			$content .= $this->getField($field, $values[$name], $options);
		}

		return $content;
	}

	private function getField($field, $value, $options = []) {
		$field->alias = $field->alias ?: $field->name;
		$params = $field->toArray();

		$params['value'] = $value;
		if (!empty($field->settings)) {
			$params['settings'] = json_decode($field->settings, true);
		}

		return $this->output($field['type'], $params, $options);
	}

	public function control($params = [], $options = []) {
		$params = array_merge([
			'type' => 'default',
			'value' => '',
		], $params);

		return $this->output($params['type'], $params, $options);
	}

	private function output($type, $params, $options = []) {
		if (!isset($params['alias'])) {
			$params['alias'] = $params['name'];
		}

		if (in_array($type, $this->FieldHandler->types)) {
			return $this->_View->element('Fieldtypes' . DS . 'default', ['params' => $params, 'options' => $options]);
		}

		try {
			return $this->_View->element('Fieldtypes' . DS . $type, ['params' => $params, 'options' => $options]);
		} catch (MissingElementException $th) {
			return $this->_View->element('Fieldtypes' . DS . 'default', ['params' => $params, 'options' => $options]);
		}
	}
}
