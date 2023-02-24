<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomersFixture
 */
class CustomersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-02-23 15:23:14',
                'modified' => '2023-02-23 15:23:14',
                'equipmentNumber' => 1,
                'sapNumber' => 1,
                'street' => 'Lorem ipsum dolor sit amet',
                'district' => 'Lorem ipsum dolor sit amet',
                'city' => 'Lorem ipsum dolor sit amet',
                'postcode' => 'Lorem ipsum dolor sit amet',
                'houseNumber' => 'Lorem ipsum dolor sit amet',
                'salutation_id' => 1,
            ],
        ];
        parent::init();
    }
}
