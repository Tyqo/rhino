<?php
declare(strict_types=1);

namespace Tusk\Model;

trait ApplicationTrait {
	
	public $emptyString = "-- empty --";

	public function prepareSelect(array $options) : array {
		$_options = $this->setValueAsKey($options);
		return $this->addEmptyOption($_options);
	}

	public function setValueAsKey(array $options) : array {
		return array_combine($options, $options);
	}

	public function addEmptyOption(array $options) : array {
		// combine with "+" insted of array_merge to keep the keys
		return ["" => $this->emptyString] + $options;
	}
}