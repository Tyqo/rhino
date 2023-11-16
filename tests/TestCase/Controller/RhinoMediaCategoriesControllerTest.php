<?php
declare(strict_types=1);

namespace Rhino\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Rhino\Controller\RhinoMediaCategoriesController;

/**
 * Rhino\Controller\RhinoMediaCategoriesController Test Case
 *
 * @uses \Rhino\Controller\RhinoMediaCategoriesController
 */
class RhinoMediaCategoriesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'plugin.Rhino.RhinoMediaCategories',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \Rhino\Controller\RhinoMediaCategoriesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Rhino\Controller\RhinoMediaCategoriesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \Rhino\Controller\RhinoMediaCategoriesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \Rhino\Controller\RhinoMediaCategoriesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \Rhino\Controller\RhinoMediaCategoriesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
