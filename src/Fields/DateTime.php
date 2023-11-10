<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;
use Cake\I18n\DateTime as CakeDateTime;

class Datetime extends Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field) {
		$current = $field->standard == 'current_timestamp()';
		$update = $field->extra == 'on update current_timestamp()';
		if ($current || $update) {
			$field['displayOptions'] = ['disabled'];
		}
		return $field;
	}

	static public function saveField($value, $field) {
		$update = $field->extra == 'on update current_timestamp()';
		if ($update) {
			return CakeDateTime::now();
		}

		return $value;
	}

	static public function displayField($value, $field) {
		if (empty($value)) {
			return;
		}

		$locale = self::getLocal();
		CakeDateTime::setDefaultLocale($locale);
		return $value->nice();
	}
}
