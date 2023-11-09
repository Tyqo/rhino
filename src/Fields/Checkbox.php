<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Fields\Field;

class Checkbox extends Field {

	static public function loadOption() {
		return [];
	}

	static public function prepareField($field) {
		return $field;
	}

	static public function displayField($value, $field) {
		$checked = $value ? "checked" : '';
		return '<input disabled type="checkbox"' . $checked . '/>';
	}
}
