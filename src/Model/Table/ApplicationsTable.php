<?php
declare(strict_types=1);

namespace Rhino\Model\Table;

use Cake\ORM\Table;

use Migrations\Migrations;
use Migrations\AbstractMigration;

class ApplicationsTable extends Table
{
	public $tableBlackList = [
		"phinxlog",
		"rhino_phinxlog",
		'rhino_users',
		'rhino_roles',
		'rhino_groups',
		'rhino_apps',
		'rhino_fields',
		'rhino_pages',
		'rhino_nodes',
		'rhino_layouts',
		'rhino_elements',
		'rhino_contents',
		'rhino_media',
		'rhino_media_categories',
		'rhino_widgets',
		'rhino_widget_categories',
        'rhino_templates'
	];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
		parent::initialize($config);

        $this->setTable('rhino_apps');
		$this->setDisplayField('id');
        $this->setPrimaryKey('id');

		// Create Abstact to start Database Operations
		$migrations = new Migrations;
		$migrations->setInput($migrations->getInput('Seed', [], []));
		$manager = $migrations->getManager($migrations->getConfig());
		$env = $manager->getEnvironment('default');

		// Use Abstract to alter database
		// https://book.cakephp.org/phinx/0/en/migrations.html
		$this->abstract = new AbstractMigration('default', 1);
		$this->abstract->setAdapter($env->getAdapter());
    }

	public function getByName($tableName) {
		$query = $this->find()->where(['Applications.name' => $tableName]);

		if ($query->all()->isEmpty()) {
			return false;
		}

		return $query->first();
	}

	public function getList(array $filter = [], bool $filtered = true) {
		$balcklist = $filter;
		if ($filtered) {
			$balcklist = array_merge($this->tableBlackList, $filter);
		}
		$_tables = $this->abstract->query("show tables")->fetchAll();

		$tables = [];
		foreach ($_tables as $table) {
			$tableName = $table[0];
			if (in_array($tableName, $balcklist)) {
				continue;
			}
			$tables[] = $tableName;
		}

		return $tables;
	}

	public function beforeMarshal($event, $data, $options) {
		if (!empty($data['overviewFields'])) {
			$data['overviewFields'] = json_encode($data['overviewFields']);
		}
	}

	public function hasTable(string $tableName) : bool {
		return $this->abstract->hasTable($tableName);
	}

	public function create(string $tableName) : void {
		$table = $this->abstract->table($tableName);
		$table->create();
	}

	public function rename(string $tableName, string $newName) : void {
		$table = $this->abstract->table($tableName);
		$table->rename($newName)->update();
	}

	public function drop(string $tableName) : void {
		$table = $this->abstract->table($tableName);
		$table->drop()->save();
	}
}
