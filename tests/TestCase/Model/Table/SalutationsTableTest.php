<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalutationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalutationsTable Test Case
 */
class SalutationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalutationsTable
     */
    protected $Salutations;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Salutations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Salutations') ? [] : ['className' => SalutationsTable::class];
        $this->Salutations = $this->getTableLocator()->get('Salutations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Salutations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SalutationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
