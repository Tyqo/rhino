<?php
declare(strict_types=1);

namespace Tusk\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;
use Tusk\View\Cell\SidebarCell;

/**
 * Tusk\View\Cell\SidebarCell Test Case
 */
class SidebarCellTest extends TestCase
{
    /**
     * Request mock
     *
     * @var \Cake\Http\ServerRequest|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $request;

    /**
     * Response mock
     *
     * @var \Cake\Http\Response|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $response;

    /**
     * Test subject
     *
     * @var \Tusk\View\Cell\SidebarCell
     */
    protected $Sidebar;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->request = $this->getMockBuilder('Cake\Http\ServerRequest')->getMock();
        $this->response = $this->getMockBuilder('Cake\Http\Response')->getMock();
        $this->Sidebar = new SidebarCell($this->request, $this->response);
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
     * Test display method
     *
     * @return void
     * @uses \Tusk\View\Cell\SidebarCell::display()
     */
    public function testDisplay(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
