<?php
declare(strict_types=1);

namespace Rhino\Test\Fixture;

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
                'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'template' => 'Lorem ipsum dolor sit amet',
                'widget_category_id' => 1,
                'position' => 1,
                'created' => 1701096531,
                'modified' => 1701096531,
            ],
        ];
        parent::init();
    }
}
