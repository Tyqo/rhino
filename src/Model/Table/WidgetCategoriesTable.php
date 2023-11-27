<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WidgetCategories Model
 *
 * @method \Rhino\Model\Entity\WidgetCategory newEmptyEntity()
 * @method \Rhino\Model\Entity\WidgetCategory newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\WidgetCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class WidgetCategoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rhino_widget_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->hasMany('Widgets', [
            'foreignKey' => 'widget_category_id',
            'className' => 'Rhino.Widgets',
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

        return $validator;
    }
}
