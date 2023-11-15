<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Cake\I18n\DateTime as CakeDateTime;

class Datetime extends Field {

	public function load($value) {
		$displayOptions = [];
		$current = $this->field->standard == 'current_timestamp()';
		$update = $this->field->extra == 'on update current_timestamp()';
		if ($current || $update) {
			$displayOptions = ['disabled'];
		}
		return $displayOptions;
	}

	public function save($value, $entry) {
		$update = $this->field->extra == 'on update current_timestamp()';
		if ($update) {
			return CakeDateTime::now();
		}

		return $value;
	}

	function display($value, $entry) {
		if (empty($value)) {
			return;
		}

		$locale = $this->getLocal();
		CakeDateTime::setDefaultLocale($locale);
		return $value->nice();
	}
}
