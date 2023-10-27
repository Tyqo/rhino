<?php
declare(strict_types=1);

namespace Tusk\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SidebarFixture
 */
class SidebarFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'sidebar';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
