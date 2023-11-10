<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;
use NumberFormatter;

class Decimal extends Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field) {
		return $field;
	}

	static public function saveField($value, $field) {
		$value = self::round($value, $field->options['decimals']);
		return $value;
	}

	static public function displayField($value, $field) {
		if (empty($value)) {
			return 0;
		}
		
		$locale = self::getLocal();
		$Formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
		return $Formatter->format($value);
	}

	static private function round($value, $decimals) {
		$value = (float)number_format((float)$value, 2, '.', '');
		if (!empty($decimals)) {
			return round($value, (int)$decimals);
		}
		return $value;
	}
}
