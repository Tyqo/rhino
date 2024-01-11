<?php
declare(strict_types=1);

namespace Rhino\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NodeTreeFixture
 */
class NodeTreeFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'node_tree';
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
                'created' => 1704372083,
                'modified' => 1704372083,
                'user_id' => 1,
                'node_type' => 'Lorem ipsum dolor sit amet',
                'role' => 'Lorem ipsum dolor sit amet',
                'parent_id' => 1,
                'lft' => 1,
                'rght' => 1,
                'level' => 1,
                'template_id' => 1,
                'language' => 'Lorem ipsum dolor sit amet',
                'version' => 1,
                'config' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            ],
        ];
        parent::init();
    }
}
