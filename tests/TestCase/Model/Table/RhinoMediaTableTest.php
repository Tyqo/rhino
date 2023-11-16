<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\RhinoMediaTable;

/**
 * Rhino\Model\Table\RhinoMediaTable Test Case
 */
class RhinoMediaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\RhinoMediaTable
     */
    protected $RhinoMedia;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoMedia',
        'plugin.Rhino.RhinoMediaCategories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RhinoMedia') ? [] : ['className' => RhinoMediaTable::class];
        $this->RhinoMedia = $this->getTableLocator()->get('RhinoMedia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhinoMedia);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoMediaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoMediaTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
