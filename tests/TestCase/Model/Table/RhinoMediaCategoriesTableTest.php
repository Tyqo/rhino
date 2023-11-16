<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhino\Model\Table\RhinoMediaCategoriesTable;

/**
 * Rhino\Model\Table\RhinoMediaCategoriesTable Test Case
 */
class RhinoMediaCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhino\Model\Table\RhinoMediaCategoriesTable
     */
    protected $RhinoMediaCategories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoMediaCategories',
        'plugin.Rhino.RhinoMedia',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RhinoMediaCategories') ? [] : ['className' => RhinoMediaCategoriesTable::class];
        $this->RhinoMediaCategories = $this->getTableLocator()->get('RhinoMediaCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhinoMediaCategories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhino\Model\Table\RhinoMediaCategoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
