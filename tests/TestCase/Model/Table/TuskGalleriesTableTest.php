<?php
declare(strict_types=1);

namespace Rhno\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Rhno\Model\Table\RhnoGalleriesTable;

/**
 * Rhno\Model\Table\RhnoGalleriesTable Test Case
 */
class RhnoGalleriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Rhno\Model\Table\RhnoGalleriesTable
     */
    protected $RhnoGalleries;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhno.RhnoGalleries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RhnoGalleries') ? [] : ['className' => RhnoGalleriesTable::class];
        $this->RhnoGalleries = $this->getTableLocator()->get('RhnoGalleries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RhnoGalleries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Rhno\Model\Table\RhnoGalleriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
