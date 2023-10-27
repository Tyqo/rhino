<?php
declare(strict_types=1);

namespace Tusk\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TuskGalleriesFixture
 */
class TuskGalleriesFixture extends TestFixture
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
                'active' => 1,
                'position' => 1,
                'created' => 1687855621,
                'modified' => 1687855621,
                'user_id' => 1,
            ],
        ];
        parent::init();
    }
}
