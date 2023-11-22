<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Expression\QueryExpression;

class ContentsTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('rhino_contents');
        $this->setDisplayField('content');
        $this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Rhino.Pages');
		$this->belongsTo('Rhino.Elements');
    }
		
	public function beforeSave($event, $entity, $options) {
		return $this->setPosition($entity);
	}

	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function setPosition($entity) {
		if ($entity->isNew()) {
			$last = $this->find()->select(['position'])->orderBy(['position' => 'DESC'])->first();
			$entity->position = $last->position + 1;
			return $entity;
		}

		$oldEntity = $this->get($entity->id);
		$newPos = $entity->position;
		$oldPos = $oldEntity->position;

		if ($newPos == $oldPos) {
			return;
		}

		if ($newPos < $oldPos) {
			$expression = new QueryExpression('position = position + 1');
			$statement = ['page_id' => $entity->page_id, 'position <=' => $oldPos, 'position >=' => $newPos];
		} else {
			$expression = new QueryExpression('position = position - 1');
			$statement = ['page_id' => $entity->page_id, 'position >=' => $oldPos, 'position <=' => $newPos, 'position !=' => 0];
		}

		$this->updateAll(
			[$expression],
			$statement
		);

		return $entity;
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
            ->integer('page_id')
            ->allowEmptyString('page_id');

        $validator
            ->integer('element_id')
            ->allowEmptyString('element_id');

        $validator
            ->scalar('html')
            ->allowEmptyString('html');

        $validator
            ->boolean('active')
            ->allowEmptyString('active');

        $validator
            ->integer('position')
            ->allowEmptyString('position');

        return $validator;
    }
}