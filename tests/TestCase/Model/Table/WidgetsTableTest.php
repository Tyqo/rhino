<?php
declare(strict_types=1);

namespace Tusk\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Tusk\Model\Table\WidgetsTable;

/**
 * Tusk\Model\Table\WidgetsTable Test Case
 */
class WidgetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Tusk\Model\Table\WidgetsTable
     */
    protected $Widgets;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Tusk.Widgets',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Widgets') ? [] : ['className' => WidgetsTable::class];
        $this->Widgets = $this->getTableLocator()->get('Widgets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Widgets);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Tusk\Model\Table\WidgetsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
