<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Field {
	use ApplicationTrait;

	static public function loadOption() {
		return null;
	}

	static public function prepareField($field) {
		return $field;
	}

	static public function displayField($value, $field) {
		return $value;
	}
}
