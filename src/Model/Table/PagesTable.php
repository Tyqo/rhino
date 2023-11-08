<?php

declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use function PHPSTORM_META\map;

class PagesTable extends Table {
	public array $root = [null => 'Root'];

	public array $pageTypes = [
		0 => "Page",
		1 => "Link",
		2 => "Folder"
	];

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('rhino_pages');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->addBehavior('Tree', [
			'level' => 'level'
		]);

		$this->hasMany('Rhino.Contents')
			->setForeignKey('page_id')
			->setDependent(true);

		$this->hasOne('Rhino.Pages');
		$this->belongsTo('Rhino.Layouts');
	}

	public function afterSave($event, $entity, $options) {
		if (!$entity["is_homepage"]) {
			return;
		}

		$pages = $this->find()
			->where(["is_homepage" => 1])
			->all()
			->toArray();

		array_walk($pages, function ($page) use ($entity) {
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

	public function getMenu(?int $root = null) {
		$_menu = $this->find('threaded')->orderBy(["lft" => 'ASC']);
		if (!empty($root)) {
			$_menu->find('children', for: $root);
		}

		// Todo: do this in Query
		$menu = $this->filterInactive($_menu->toArray());

		return $menu;
	}

	private function filterInactive($input) {
		$output = [];
		foreach ($input as $page) {
			if ($page->active) {
				$page->children = $this->filterInactive($page->children);
				$output[] = $page;
			}
		}
		return $output;
	}
}
