<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\NodeTreeTable;

/**
 * Rhino\Model\Table\NodeTreeTable Test Case
 */
class NodeTreeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\NodeTreeTable
     */
    protected $NodeTree;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.NodeTree',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('NodeTree') ? [] : ['className' => NodeTreeTable::class];
        $this->NodeTree = $this->getTableLocator()->get('NodeTree', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->NodeTree);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\NodeTreeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Rhino\Model\Table\NodeTreeTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
