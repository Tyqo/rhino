<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PagesTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('tusk_pages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

		$this->hasMany('Tusk.Contents')
			->setForeignKey('page_id')
            ->setDependent(true);

		$this->hasOne('Tusk.Pages');
		$this->belongsTo('Tusk.Layouts');
    }

	public function afterSave($event, $entity, $options) {
		if (!$entity["is_homepage"]) {
			return;
		}
		
		$pages = $this->find()
			->where(["is_homepage" => 1])
			->all()
			->toArray();
		
		array_walk($pages, function ($page) use($entity) {
			if ($page["id"] == $entity["id"] || !$page["is_homepage"]) {
				return;
			}

			$page["is_homepage"] = false;
			$this->save($page);
		});
	}
		
	public function getEntry(int $id = null): object {
		if (!empty($id)) {
			return $this->get($id);
		}
		
		return $this->newEmptyEntity();
	}

	public function slug(string $slug = null) {
		$contain = [
			'Contents' => [
				'Elements', 
				'sort' => [
					'Contents.position' => 'ASC'
				]
			],
			'Layouts'
		];

		$where = ["Pages.name" => $slug];

		if (!$slug) {
			$where = ["is_homepage" => 1];
		}

		$query = $this->find()
				->where($where)
				->contain($contain);

		return $query->first();
	}
	
	public function getChildren($parentId, $pages) {
		$children = [];

		foreach ($pages as $page) {
			if ($page['parent'] != $parentId) {
				continue;
			}
		
			$page['children'] = $this->getChildren($page['id'], $pages);
			$children[] = $page;
		}

		return $children;
	}
}