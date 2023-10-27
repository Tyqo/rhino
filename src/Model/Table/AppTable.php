<?php

declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Table;
use Tusk\Handlers\FieldHandler;

class AppTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
		$this->FieldHandler = new FieldHandler();
	}


	public function beforeFind() {
		$tableName = $this->getTable();
		$fields = $this->FieldHandler->getFields($tableName);
	}
}
