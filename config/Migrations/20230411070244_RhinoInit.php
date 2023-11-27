<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RhinoInit extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void {
		$usersTable = 'rhino_users';
		$rolesTable = 'rhino_roles';
		$layoutsTable = 'rhino_layouts';
		$elementsTable = 'rhino_elements';
		$contentsTable = 'rhino_contents';
		$pagesTable = 'rhino_pages';
		$options = [
			"collation" => 'utf8mb4_unicode_ci'
		];

		$this->table($usersTable, $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('email', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('role_id', 'string', [
				'default' => 1,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('theme', 'string', [
				'default' => 'rhino',
				'null' => false,
			])
			->addColumn('password', 'string', [
				'default' => null,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table($rolesTable, $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('access', 'text', [
				'default' => null,
				'null' => false,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('rhino_fields', $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('alias', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => true,
			])
			->addColumn('tableName', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('type', 'string', [
				'default' => 'string',
			])
			->addColumn('description', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('standard', 'string', [ // default as column name throws errors
				'default' => null,
				'null' => true,
			])
			->addColumn('settings', 'text', [
				'default' => null,
				'null' => true,
			])
			->create();

		$this->table('rhino_apps', $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('alias', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('overviewFields', 'string', [
				'default' => null,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('rhino_group_id', 'integer', [
				'null' => true
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('rhino_groups', $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table($pagesTable, $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('is_homepage', 'boolean', [
				'default' => 0,
			])
			->addColumn('page_type', 'integer', [
				'default' => 0,
			])
			->addColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => 11,
				'null' => true,
			])
			->addColumn('lft', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('rght', 'integer', [
				'default' => null,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('level', 'integer', [
				'default' => 0,
				'limit' => 10,
				'null' => false,
			])
			->addColumn('url', 'string', [
				'null' => true,
			])
			->addColumn('layout_id', 'integer', [
				'default' => 0,
			])
			->addColumn('created', 'timestamp', [
				'null' => false,
				'default' => 'CURRENT_TIMESTAMP',
			])
			->addColumn('modified', 'timestamp', [
				'null' => false,
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP',
			])
			->addIndex(['lft'], ['name' => 'idx_lft'])
			->addIndex(['parent_id'])
			->create();

		$this->table($layoutsTable, $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('layout', 'string', [
				'default' => null,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();
		
		$this->table($elementsTable, $options)
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 100,
				'null' => false,
			])
			->addColumn('element', 'string', [
				'default' => null,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();
		
		$this->table($contentsTable, $options)
			->addColumn('page_id', 'integer', [
				'default' => Null,
			])
			->addColumn('element_id', 'integer', [
				'default' => Null,
			])
			->addColumn('html', 'text', [
				'default' => null,
				'null' => true,
			])
			->addColumn('media', 'string', [
				'default' => null,
				'null' => true,
			])
			->addColumn('active', 'boolean', [
				'default' => 1,
			])
			->addColumn('position', 'integer', [
				'default' => 0,
			])
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('rhino_media', $options)
			->addColumn('filename', 'string')
			->addColumn('description', 'text')
			->addColumn('type', 'string')
			->addColumn('position', 'integer')
			->addColumn('media_category_id', 'integer')
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		$this->table('rhino_media_categories', $options)
			->addColumn('name', 'string')
			->addColumn('description', 'text')
			->create();

		$this->table('rhino_widget_categories', $options)
			->addColumn('name', 'string')
			->addColumn('description', 'text')
			->create();

		$this->table('rhino_widgets', $options)
			->addColumn('name', 'string')
			->addColumn('description', 'text')
			->addColumn('template', 'string')
			->addColumn('widget_category_id', 'integer')
			->addColumn('position', 'integer')
			->addColumn('created', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP'
			])
			->addColumn('modified', 'timestamp', [
				'default' => 'CURRENT_TIMESTAMP',
				'update' => 'CURRENT_TIMESTAMP'
			])
			->create();

		if ($this->isMigratingUp()) {
			$this->table($rolesTable)
				->insert([
					[
						'name' => 'Admin',
						'access' => ''
					],
					[
						'name' => 'Redakteur',
						'access' => ''
					],
					[
						'name' => 'User',
						'access' => ''
					]
				])
				->saveData();

			$this->table($layoutsTable)
				->insert([
					[
						'name' => 'Default',
						'layout' => 'default',
					]
				])
				->saveData();
				
			$this->table($elementsTable)
				->insert([
					[
						'name' => 'Text',
						'element' => 'text',
					]
				])
				->saveData();
						
			$this->table($pagesTable)
				->insert([
					[
						'name' => 'Home',
						'is_homepage' => 1,
						'layout_id' => 1,
						'lft' => '0',
						'rght' => '0',
					]
				])
				->saveData();
					
			$this->table($contentsTable)
				->insert([
					[
						'page_id' => 1,
						'element_id' => 1,
						'html' => '{"time":1690121834854,"blocks":[{"id":"BkMrFh55lD","type":"header","data":{"text":"Welcome to Rhino &#x1F98F;","level":1}},{"id":"R_LcFT6kwI","type":"paragraph","data":{"text":"The fast but stable Application-Framwork.<br>Powered by <a href=\"https://cakephp.org/\">CakePHP</a>."}}],"version":"2.26.5"}'
					]
				])
				->saveData();
		}
    }
}
