<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

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

        $this->setTable('tusk_contents');
        $this->setDisplayField('content');
        $this->setPrimaryKey('id');

		$this->belongsTo('Tusk.Pages');
		$this->belongsTo('Tusk.Elements');
    }
		
	public function beforeSave($event, $entity, $options) {
		$this->setPosition($entity);
	}

	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function setPosition($entity) {
		if ($entity->isNew()) {
			return;
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
	}
}