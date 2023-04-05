<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Inital extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
		$table = $this->table('customers');
        $table->addColumn('full_name', 'string', [
            'default' => null,
            'limit' => 100,
            'null' => false,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('modified', 'datetime');
        $table->create();
    }
}
