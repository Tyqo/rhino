<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Fields\Field;

class Checkbox extends Field {

	public function load($value) {
		$displayOptions = [];
		$options = $this->options;

		if (!empty($options['checkboxStyle'])) {
			$displayOptions = ['role' => $options['checkboxStyle']];
		}

		return $displayOptions;
	}

	public function display($value, $entity) {
		$attrs = [
			'role' => 'switch',
			'type' => 'checkbox',
			'disabled'
		];

		if ($value) {
			$attrs['checked'] = true;
		}
		
		if (!empty($this->options['checkboxStyle'])) {
			$attrs['role'] = $this->options['checkboxStyle'];
		}

		return $this->Templater->format('input', [
			'attrs' => $this->Templater->formatAttributes($attrs)
		]);
	}
}
