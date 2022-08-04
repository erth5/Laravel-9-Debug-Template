<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteViewTest extends TestCase
{

    /**
     * A basic unit test that proof if the domain root is visible.
     * @group routing
     * @return void
     */
    public function test_routing_main()
    {
        $pathResponse = $this->get('/');
        $pathResponse->assertStatus(200);
    }

    /**
     * A basic unit test for debug.
     * @group routing
     * @return void
     */
    public function test_ONLYDEBUG_routing_debug()
    {
        $pathResponse = $this->get('/debug');
        $pathResponse->assertStatus(200);
    }

    public function test_ONLYDEBUG_db_connection_view()
    {
        $viewDb = $this->get('/test/db');
        $viewDb->assertStatus(200);
    }

    public function test_ONLYDEBUG_users_and_peoples_table_view()
    {
        $viewUser = $this->get('/debug/user');
        $viewUser->assertStatus(200);
        // AssertEuqals(Person surname = User surname);
    }
}
