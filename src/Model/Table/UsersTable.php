<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Rhino\Model\Table\ArticlesTable&\Cake\ORM\Association\HasMany $Articles
 *
 * @method \Rhino\Model\Entity\User newEmptyEntity()
 * @method \Rhino\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \Rhino\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \Rhino\Model\Entity\User get($primaryKey, $options = [])
 * @method \Rhino\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \Rhino\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Rhino\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \Rhino\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Rhino\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \Rhino\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('rhino_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', ['className' => 'Rhino.Roles']);
    }

	public function afterMarshal($event, $entity, $data) {
		if (isset($data['newPassword']) && !empty($data['newPassword'])) {
			$entity['password'] = $data['newPassword'];
		} else {
			unset($data['password']);
		}
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
            ->add('newPassword', 'validPassword', [
                'rule' => function ($value, $context) {
					if ($value !== $context['data']['repeatPassword']) {
						return "Password does not match.";
					}

					return true;
				}
            ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');
			
		$validator
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}