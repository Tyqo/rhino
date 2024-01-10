<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\ResultSet;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NodeTree Model
 *
 * @property \Rhino\Model\Table\NodeTreeTable&\Cake\ORM\Association\BelongsTo $ParentNodeTree
 * @property \Rhino\Model\Table\NodeTreeTable&\Cake\ORM\Association\HasMany $ChildNodeTree
 *
 * @method \Rhino\Model\Entity\NodeTree newEmptyEntity()
 * @method \Rhino\Model\Entity\NodeTree newEntity(array $data, array $options = [])
 * @method array<\Rhino\Model\Entity\NodeTree> newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\NodeTree get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \Rhino\Model\Entity\NodeTree findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \Rhino\Model\Entity\NodeTree patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\Rhino\Model\Entity\NodeTree> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\NodeTree|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \Rhino\Model\Entity\NodeTree saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\Rhino\Model\Entity\NodeTree>|\Cake\Datasource\ResultSetInterface<\Rhino\Model\Entity\NodeTree>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\Rhino\Model\Entity\NodeTree>|\Cake\Datasource\ResultSetInterface<\Rhino\Model\Entity\NodeTree> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\Rhino\Model\Entity\NodeTree>|\Cake\Datasource\ResultSetInterface<\Rhino\Model\Entity\NodeTree>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\Rhino\Model\Entity\NodeTree>|\Cake\Datasource\ResultSetInterface<\Rhino\Model\Entity\NodeTree> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class NodesTable extends Table {
	public array $root = [0 => 'Root'];

	public array $nodeTypes = [
		0 => "Page",
		1 => "Component",
		2 => "Content"
	];

	public array $roles = [
		0 => "default",
		1 => "main"
	];


    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rhino_nodes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree', [
			'level' => 'level'
		]);

		$this->hasOne('Users', [
            'className' => 'Rhino.Users',
            'foreignKey' => 'user_id',
        ]);

		$this->belongsTo('Parent', [
			'className' => 'Rhino.Nodes',
            'foreignKey' => 'id',
		]);
		
		$this->hasMany('Children', [
			'className' => 'Rhino.Nodes',
            'foreignKey' => 'parent_id',
		]);

		$this->belongsTo('Templates', [
			'className' => 'Rhino.Templates',
		]);
    }

	public function getChildren(int $parentId): ResultSet {
		return $this->find()
			->where(['parent_id' => $parentId])
			->contain(['Templates'])
			->orderBy(['lft' => 'ASC'])
			->all();
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmptyString('user_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->notEmptyString('type');

        $validator
            ->scalar('role')
            ->maxLength('role', 255)
            ->allowEmptyString('role');

        $validator
            ->integer('parent_id')
            ->allowEmptyString('parent_id');

        $validator
            ->integer('level')
            ->notEmptyString('level');

        $validator
            ->integer('template_id')
            ->allowEmptyString('template_id');

        $validator
            ->scalar('language')
            ->maxLength('language', 255)
            ->allowEmptyString('language');

        $validator
            ->integer('version')
            ->allowEmptyString('version');

        $validator
            ->scalar('config')
            ->allowEmptyString('config');

        $validator
            ->scalar('content')
            ->allowEmptyString('content');

        return $validator;
    }

}
