<?php
declare(strict_types=1);

namespace Rhino\Model;

trait ApplicationTrait {
	
	public static string $emptyString = "-- empty --";

	public static function prepareSelect(array $options) : array {
		$_options = self::setValueAsKey($options);
		return self::addEmptyOption($_options);
	}

	public static function setValueAsKey(array $options) : array {
		return array_combine($options, $options);
	}

	public static function addEmptyOption(array $options) : array {
		// combine with "+" insted of array_merge to keep the keys
		return ["" => self::$emptyString] + $options;
	}
}