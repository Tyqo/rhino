<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\RhinoContentsTable;

/**
 * Rhino\Model\Table\RhinoContentsTable Test Case
 */
class RhinoContentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\RhinoContentsTable
     */
    protected $RhinoContents;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoContents',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RhinoContents') ? [] : ['className' => RhinoContentsTable::class];
        $this->RhinoContents = $this->getTableLocator()->get('RhinoContents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhinoContents);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoContentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
