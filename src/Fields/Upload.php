<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Upload extends Field {
	
	use ApplicationTrait;

	public function load($field, $value = null) {
		$displayOptions = [
			"type" => 'text',
			'value' => $value
		];

		return $displayOptions;
	}

	public function display($value, $entry) {
		if (empty($value)) {
			return;
		}

		$image = '<img src="' . DS . $this->field['options']['uploadDirectory'] . $value . '" style="width: 120px" />';
		return $image;
	}

	public function save($value, $entity) {
		if (is_string($value)) {
			return $value;
		}

		$name = $value->getClientFilename();
		$value->moveTo(WWW_ROOT . $this->field['options']['uploadDirectory'] . $name);
		return $name;
	}
}
