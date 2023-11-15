<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Fields\Field;

class Date extends Field {
	public function display($value, $entry) {
		if (empty($value)) {
			return;
		}

		return $value->nice();
	}
}
