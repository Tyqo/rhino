<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RhinoMedias Model
 *
 * @property \Rhino\Model\Table\RhinoMediaCategoriesTable&\Cake\ORM\Association\BelongsTo $RhinoMediaCategories
 *
 * @method \Rhino\Model\Entity\RhinoMedia newEmptyEntity()
 * @method \Rhino\Model\Entity\RhinoMedia newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMedia[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediaTable extends Table
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

        $this->setTable('rhino_media');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('MediaCategories', [
            'foreignKey' => 'media_category_id',
            'className' => 'Rhino.MediaCategories',
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
            ->scalar('filename')
            ->maxLength('filename', 255)
            ->allowEmptyFile('filename');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('filetype')
            ->maxLength('filetype', 255)
            ->allowEmptyFile('filetype');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        $validator
            ->integer('media_category_id')
            ->allowEmptyString('media_category_id');

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
        $rules->add($rules->existsIn('media_category_id', 'RhinoMediaCategories'), ['errorField' => 'media_category_id']);

        return $rules;
    }
}
