<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Fields\Field;

class Checkbox extends Field {

	static public function loadOption() {
		return [];
	}

	static public function loadField($field, $value = null) {
		$options = $field->options;
		if (!empty($options['checkboxStyle'])) {
			$field['displayOptions'] = ['role' => $options['checkboxStyle']];
		}
		return $field;
	}

	static public function displayField($value, $field, $entry) {
		$checked = $value ? "checked" : '';
		$options = $field->options;

		if (!empty($options['checkboxStyle'])) {
			$style = sprintf('%s="%s"','role', $options['checkboxStyle']);
		}

		return sprintf('<input disabled type="checkbox" %s %s/>', $checked, $style ?? '');
	}
}
