<?php
declare(strict_types=1);

namespace Tusk\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use Tusk\Model\Table\TuskGalleriesTable;

/**
 * Tusk\Model\Table\TuskGalleriesTable Test Case
 */
class TuskGalleriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Tusk\Model\Table\TuskGalleriesTable
     */
    protected $TuskGalleries;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Tusk.TuskGalleries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TuskGalleries') ? [] : ['className' => TuskGalleriesTable::class];
        $this->TuskGalleries = $this->getTableLocator()->get('TuskGalleries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TuskGalleries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Tusk\Model\Table\TuskGalleriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
