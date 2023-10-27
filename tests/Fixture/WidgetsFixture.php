<?php
declare(strict_types=1);

namespace Tusk\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * WidgetsFixture
 */
class WidgetsFixture extends TestFixture
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
            ],
        ];
        parent::init();
    }
}
