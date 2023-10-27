<?php
declare(strict_types=1);

namespace Tusk\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Tusk\Model\Table\SidebarTable;

/**
 * Tusk\Model\Table\SidebarTable Test Case
 */
class SidebarTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Tusk\Model\Table\SidebarTable
     */
    protected $Sidebar;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Tusk.Sidebar',
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
     * @uses \Tusk\Model\Table\SidebarTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
