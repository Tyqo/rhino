<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\RhinoMediasTable;

/**
 * Rhino\Model\Table\RhinoMediasTable Test Case
 */
class RhinoMediasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\RhinoMediasTable
     */
    protected $RhinoMedias;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoMedias',
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
        $config = $this->getTableLocator()->exists('RhinoMedias') ? [] : ['className' => RhinoMediasTable::class];
        $this->RhinoMedias = $this->getTableLocator()->get('RhinoMedias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhinoMedias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoMediasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoMediasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
