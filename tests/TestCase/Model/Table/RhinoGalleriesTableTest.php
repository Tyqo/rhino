<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\RhinoGalleriesTable;

/**
 * Rhino\Model\Table\RhinoGalleriesTable Test Case
 */
class RhinoGalleriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\RhinoGalleriesTable
     */
    protected $RhinoGalleries;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoGalleries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RhinoGalleries') ? [] : ['className' => RhinoGalleriesTable::class];
        $this->RhinoGalleries = $this->getTableLocator()->get('RhinoGalleries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhinoGalleries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoGalleriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
