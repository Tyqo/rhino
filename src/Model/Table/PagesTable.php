<?php

declare(strict_types=1);

namespace Rhino\Model\Table;

use Rhino\Model\Table\NodesTable;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use function PHPSTORM_META\map;

class PagesTable extends NodesTable {
	public array $root = [null => 'Root'];

	public array $pageTypes = [
		0 => "Page",
		1 => "Link",
		2 => "Folder"
	];

	public array $roles = [
		0 => "Page",
		1 => "Link",
		2 => "Folder",
		3 => "Home Page",
		4 => "Error Page",
	];

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config): void {
		parent::initialize($config);

		// $this->setTable('node_tree');
		// $this->setDisplayField('name');
		// $this->setPrimaryKey('id');

		// $this->addBehavior('Tree', [
		// 	'level' => 'level'
		// ]);

		// $this->hasMany('Rhino.Contents')
		// 	->setForeignKey('page_id')
		// 	->setDependent(true);

		// $this->hasOne('Rhino.Pages');
		// $this->belongsTo('Rhino.Layouts');
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

	public function slug(string $slug = null) {
		$where = $slug ? ["Pages.name" => $slug] : ["role" => 3];
		$where['node_type'] = 0;

		$page = $this->find()
			->where($where)
			->contain(['Templates'])
			->first();

		return $page;
	}

	public function getMenu(?int $root = null, ?int $limit = null) {
		$_menu = $this->find('threaded')->where(['node_type' => 0])->orderBy(["lft" => 'ASC']);
		if (!empty($root)) {
			$_menu->find('children', for: $root);
		}

		$menu = $_menu->toArray();

		if (isset($limit)) {
			$limit = $menu[0]->level + $limit;
		}

		// Todo: do this in Query
		$menu = $this->filterInactive($menu, $limit ?? null);

		return $menu;
	}

	private function filterInactive($input, $limit = null) {
		$output = [];
		foreach ($input as $page) {
			if (isset($limit) && $page->level > $limit) {
				continue;
			}

			if ($page->active) {
				$page->children = $this->filterInactive($page->children, $limit);
				$output[] = $page;
			}
		}
		return $output;
	}
}
