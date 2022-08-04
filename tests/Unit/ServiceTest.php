<?php

namespace Tests\Unit;

use App\Services\DebugService;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    /**
     * A basic unit test for controller.
     * @group specification
     * @return void
     */

    public function test_controller_exist()
    {
        $this->assertFileExists('app\Http\Controllers\Controller.php');
    }

    /**
     * A basic unit test for outsourced Controller Functionality.
     *
     * @return void
     */
    public function test_debug_service_function_works()
    {
        $sresp = new DebugService;
        $this->assertEquals(false, $sresp->debugFunction(false));
    }
}
