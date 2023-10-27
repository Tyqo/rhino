<?php
declare(strict_types=1);

namespace Rhno\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class LayoutsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('rhno_layouts');
        // $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		// $this->hasMany('Rhno.Elements');
		// $this->hasMany('Rhno.Pages');
    }
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}
}