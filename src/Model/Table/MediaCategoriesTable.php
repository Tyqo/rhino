<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RhinoMediaCategories Model
 *
 * @property \Rhino\Model\Table\RhinoMediaTable&\Cake\ORM\Association\HasMany $RhinoMedia
 *
 * @method \Rhino\Model\Entity\RhinoMediaCategory newEmptyEntity()
 * @method \Rhino\Model\Entity\RhinoMediaCategory newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\RhinoMediaCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MediaCategoriesTable extends Table
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

        $this->setTable('rhino_media_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Media', [
            'foreignKey' => 'media_category_id',
            'className' => 'Rhino.Media',
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
