<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RhinoGalleries Model
 *
 * @method \Rhino\Model\Entity\RhinoGallery newEmptyEntity()
 * @method \Rhino\Model\Entity\RhinoGallery newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoGallery[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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

        $this->setTable('rhino_galleries');
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
