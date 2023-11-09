<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\SidebarTable;

/**
 * Rhino\Model\Table\SidebarTable Test Case
 */
class SidebarTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\SidebarTable
     */
    protected $Sidebar;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.Sidebar',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Sidebar') ? [] : ['className' => SidebarTable::class];
        $this->Sidebar = $this->getTableLocator()->get('Sidebar', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Sidebar);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\SidebarTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
