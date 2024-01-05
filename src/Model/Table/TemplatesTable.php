<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TemplatesTable extends Table {

	public array $fieldConfig = [
		'element' => [
			'type' => 'upload',
			'options' =>  [
				'uploadDirectory' => '/templates',
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

        $this->setTable('rhino_templates');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->hasMany('Nodes', [
			'className' => 'Rhino.Nodes',
		]);
    }
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function list($type = 0) {
		return $this->find('list')
					->where(['active' => true, 'template_type' => $type])
					->select(['id', 'name'])
					->all();
	}
}