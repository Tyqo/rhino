<?php

declare(strict_types=1);

namespace Rhino\Fields;

class Upload extends Field {

	public function load($value) {
		$displayOptions = [
			'type' => 'file',
			'directory' => $this->options['uploadDirectory']
		];

		if (isset($this->options['fileTypes']) && !in_array($this->options['fileTypes'], ['file', 'folder'])) {
			$displayOptions['accepts'] = $this->options['fileTypes'];
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

		$files = explode(',', $value);

		$out = '';
		foreach ($files as $file) {
			$out .= '<img src="' . DS . $this->field['options']['uploadDirectory'] . trim($file) . '" style="width: 120px" />';
		}
		return $out;
	}

	public function save($value, $entity) {
		$file = $entity[$this->field->name . '_file'];
		$path = WWW_ROOT . $this->field['options']['uploadDirectory'];
	
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
