<?php
declare(strict_types=1);

namespace Rhno\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RhnoGalleries Model
 *
 * @method \Rhno\Model\Entity\RhnoGallery newEmptyEntity()
 * @method \Rhno\Model\Entity\RhnoGallery newEntity(array $data, array $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[] newEntities(array $data, array $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery get($primaryKey, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhno\Model\Entity\RhnoGallery[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class GalleriesTable extends Table
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

        $this->setTable('rhno_galleries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->nonNegativeInteger('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

        $validator
            ->nonNegativeInteger('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

        return $validator;
    }
}
