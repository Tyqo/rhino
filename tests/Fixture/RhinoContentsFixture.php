<?php
declare(strict_types=1);

namespace Rhino\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RhinoContentsFixture
 */
class RhinoContentsFixture extends TestFixture
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
                'page_id' => 1,
                'element_id' => 1,
                'html' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'active' => 1,
                'position' => 1,
                'created' => 1700576983,
                'modified' => 1700576983,
            ],
        ];
        parent::init();
    }
}
