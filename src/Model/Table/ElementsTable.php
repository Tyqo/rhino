<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ElementsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('tusk_elements');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->belongsToMany('Tusk.Layouts');
		$this->belongsToMany('Tusk.Contents');
    }
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}
}