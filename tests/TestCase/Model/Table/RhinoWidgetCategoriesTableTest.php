<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\WidgetCategoriesTable;

/**
 * Rhino\Model\Table\WidgetCategoriesTable Test Case
 */
class WidgetCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\WidgetCategoriesTable
     */
    protected $WidgetCategories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.WidgetCategories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('WidgetCategories') ? [] : ['className' => WidgetCategoriesTable::class];
        $this->WidgetCategories = $this->getTableLocator()->get('WidgetCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->WidgetCategories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\WidgetCategoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
