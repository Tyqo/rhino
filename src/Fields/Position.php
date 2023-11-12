<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;

class Position {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field, $value = null) {
		return $field;
	}

	static public function displayField($value, $field, $entry) {
		$button = '<a href="%s" class="button">%s</a>';
		$up = sprintf($button, self::moveLink('up', $field, $entry->id), 'up');
		$down = sprintf($button, self::moveLink('down', $field, $entry->id), 'down');
		$value = ' <b>' . $value . '</b> ';
		return $up . $value . $down;
	}

	static public function saveField($value, $field) {
		return $value;
	}

	static public function moveLink($action, $field, $id) {
		return sprintf('/rhino/tables/move%s/%s/%s/%s', ucfirst($action), $field->tableName, $field->name, $id);
	}
}
