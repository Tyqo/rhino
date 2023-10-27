<?php
declare(strict_types=1);

namespace Tusk\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
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
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-02-28 12:09:17',
                'modified' => '2023-02-28 12:09:17',
            ],
        ];
        parent::init();
    }
}
