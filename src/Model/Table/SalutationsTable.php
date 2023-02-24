<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Salutations Model
 *
 * @method \App\Model\Entity\Salutation newEmptyEntity()
 * @method \App\Model\Entity\Salutation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Salutation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Salutation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Salutation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Salutation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Salutation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Salutation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Salutation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Salutation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Salutation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Salutation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Salutation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SalutationsTable extends Table
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

        $this->setTable('salutations');
        $this->setDisplayField('id');
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
            ->scalar('salutation')
            ->maxLength('salutation', 255)
            ->requirePresence('salutation', 'create')
            ->notEmptyString('salutation');

        return $validator;
    }
}
