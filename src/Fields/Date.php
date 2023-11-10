<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Date extends Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field) {
		return $field;
	}

	static public function saveField($value, $field) {
		return $value;
	}

	static public function displayField($value, $field) {
		if (empty($value)) {
			return;
		}

		return $value->nice();
	}
}
