<?php

declare(strict_types=1);

namespace Rhino\Fields;

use NumberFormatter;

class Decimal extends Field {

	public function save($value, $entity) {
		$value = $this->round($value, $this->field->options['decimals']);
		return $value;
	}

	public function display($value, $entry) {
		if (empty($value)) {
			return 0;
		}
		
		$locale = self::getLocal();
		$Formatter = new NumberFormatter($locale, NumberFormatter::DECIMAL);
		return $Formatter->format($value);
	}

	private function round($value, $decimals) {
		$value = (float)number_format((float)$value, 2, '.', '');
		if (!empty($decimals)) {
			return round($value, (int)$decimals);
		}
		return $value;
	}
}
