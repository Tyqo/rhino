<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Widgets Model
 *
 * @method \Rhino\Model\Entity\Widget newEmptyEntity()
 * @method \Rhino\Model\Entity\Widget newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\Widget[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\Widget get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\Widget findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\Widget patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\Widget[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\Widget|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\Widget saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\Widget[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\Widget[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\Widget[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\Widget[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class WidgetsTable extends Table
{
	public array $fieldConfig = [
		'template' => [
			'type' => 'upload',
			'options' =>  [
				'uploadDirectory' => '/templates/element/',
				'uploadTypes' => 'file',
				'uploadOverwrite' => '',
				'uploadMultiple' => ''
			]
		],
		'position' => ['type' => 'position'],
		'widget_category_id' => 'hidden',
		'created' => false,
		'modified' => false,
	];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rhino_widgets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

		$this->belongsTo('WidgetCategories', [
            'foreignKey' => 'widget_category_id',
            'className' => 'Rhino.WidgetCategories',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('template')
            ->maxLength('template', 255)
            ->allowEmptyString('template');

        $validator
            ->integer('widget_category_id')
            ->allowEmptyString('widget_category_id');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        return $validator;
    }

	/**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('widget_category_id', 'WidgetCategories'), ['errorField' => 'widget_category_id']);

        return $rules;
    }
}