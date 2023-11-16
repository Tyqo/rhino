<?php

declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table {
	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);
	}
}
