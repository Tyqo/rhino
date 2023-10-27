<?php
declare(strict_types=1);

namespace Tusk\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TagsFixture
 */
class TagsFixture extends TestFixture
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
                'title' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-02-28 09:17:40',
                'modified' => '2023-02-28 09:17:40',
            ],
        ];
        parent::init();
    }
}
