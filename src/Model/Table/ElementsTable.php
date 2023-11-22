<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ElementsTable extends Table {

	public array $fieldConfig = [
		'element' => [
			'type' => 'upload',
			'options' =>  [
				'uploadDirectory' => '/templates/element',
				'uploadTypes' => 'file',
				'uploadOverwrite' => '',
				'uploadMultiple' => ''
			]
		],
		'created' => false,
		'modified' => false,
	];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('rhino_elements');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->belongsToMany('Rhino.Layouts');
		$this->belongsToMany('Rhino.Contents');
    }
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function list() {
		return $this->find('list')
					->where(['active' => true])
					->select(['id', 'name'])
					->all();
	}
}