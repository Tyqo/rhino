<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;
use Cake\ORM\TableRegistry;

class Position extends Field {
	use ApplicationTrait;

	static public function loadOptions() {
		return null;
	}

	static public function loadField($field, $value = null) {
		$displayOptions = [
			'hidden' => true
		];

		if (empty($value) || $value == 0) {
			try {
				$Table = TableRegistry::getTableLocator()->get(ucfirst($field->tableName));
			} catch (\Throwable $th) {
				$Table = TableRegistry::getTableLocator()->get('Rhino.Tables');
				$Table->setTable($field->tableName);
			}
			
			$query = $Table->find('all');
			$number = $query->count();
			$displayOptions['value'] = $number + 1;
		}
	
		$field['displayOptions'] = $displayOptions;

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
