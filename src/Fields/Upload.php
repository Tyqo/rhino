<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Upload extends Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field, $value = null) {
		$field['displayOptions'] = [
			"type" => 'file',
			'value' => $value
		];
		return $field;
	}

	static public function displayField($value, $field, $entry) {
		if (empty($value)) {
			return;
		}

		$image = '<img src="' . DS . $field['options']['uploadDirectory'] . $value . '" />';
		return $image;
	}

	static public function saveField($value, $field) {
		if ($value->getSize() == 0) {
			return '';
		}

		$name = $value->getClientFilename();
		$value->moveTo(WWW_ROOT . $field['options']['uploadDirectory'] . $name);
		return $name;
	}

	static public function getLocal() {
		return locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	}
}
