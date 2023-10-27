<?php
declare(strict_types=1);

namespace Rhno\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhno\Model\Table\WidgetsTable;

/**
 * Rhno\Model\Table\WidgetsTable Test Case
 */
class WidgetsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhno\Model\Table\WidgetsTable
     */
    protected $Widgets;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhno.Widgets',
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
     * @uses \Rhno\Model\Table\WidgetsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
