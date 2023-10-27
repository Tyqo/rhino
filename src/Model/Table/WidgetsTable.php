<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
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
 */
class WidgetsTable extends Table
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

        $this->setTable('rhino_widgets');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
