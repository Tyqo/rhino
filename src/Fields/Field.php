<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field) {
		return $field;
	}

	static public function displayField($value, $field) {
		return $value;
	}

	static public function saveField($value, $field) {
		return $value;
	}

	static public function getLocal() {
		return locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	}
}
