<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TuskGalleries Model
 *
 * @method \Tusk\Model\Entity\TuskGallery newEmptyEntity()
 * @method \Tusk\Model\Entity\TuskGallery newEntity(array $data, array $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[] newEntities(array $data, array $options = [])
 * @method \Tusk\Model\Entity\TuskGallery get($primaryKey, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Tusk\Model\Entity\TuskGallery|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Tusk\Model\Entity\TuskGallery[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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

        $this->setTable('tusk_galleries');
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
