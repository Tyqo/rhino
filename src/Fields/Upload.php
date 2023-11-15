<?php

declare(strict_types=1);

namespace Rhino\Fields;

class Upload extends Field {

	public function load($value) {
		$displayOptions = [
			'type' => 'file',
			'directory' => $this->options['uploadDirectory']
		];

		if (isset($this->options['uploadTypes'])) {
			$displayOptions['types'] = $this->options['uploadTypes'];

			if (!in_array($this->options['uploadTypes'], ['file', 'directory'])) {
				$displayOptions['accept'] = $this->options['uploadTypes'];
			}
		}

		if (isset($this->options['uploadMultiple']) && $this->options['uploadMultiple']) {
			$displayOptions['multiple'] = true;
		}

		return $displayOptions;
	}

	public function display($value, $entry) {
		if (empty($value)) {
			return;
		}
		
		if ($this->field->standard == $value && !empty($this->options['uploadDirectory']) && $this->options['uploadDirectory'] != DS) {
			$value = str_replace($this->options['uploadDirectory'], '', $this->field->standard);
		}

		$path = WWW_ROOT . $this->options['uploadDirectory'];
		$files = explode(',', $value);

		$out = '';
		foreach ($files as $file) {
			$type = mime_content_type($path . $file);
			if (preg_match('/(image\/*)/', $type)) {
				// $out .= '<img src="' . DS . $this->field['options']['uploadDirectory'] . trim($file) . '" style="width: 120px" />';
				$out .= $this->Templater->format('image', [
					'attrs' => $this->Templater->formatAttributes([
						'src' => DS . $this->field['options']['uploadDirectory'] . trim($file),
						'style' => 'width: 120px'
					])
				]);
			} else {
				$out .= $file;
			}
		}
		return $out;
	}

	public function save($value, $entity) {
		$file = $entity[$this->field->name . '_file'];
		$path = WWW_ROOT . $this->options['uploadDirectory'];
	
		if (is_array($file)) {
			foreach ($file as $_file) {
				$name = $_file->getClientFilename();
				if (!empty($name)) {
					$_file->moveTo($path . $name);
				}
			}
		} else {
			$name = $file->getClientFilename();
			if (!empty($name)) {
				$file->moveTo($path . $name);
			}
		}

		return $value;
	}
}
