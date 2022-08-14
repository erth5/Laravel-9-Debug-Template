<?php

namespace Tests\Feature;

use App\Actions\CallAdjust;
use App\Models\Example\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Action_works()
    {
        {
            $adjusting = (new CallAdjust)->handle();
            $this->assertEquals(
                'Lord Kennedy',
                Person::where('username', 'thespasst')
                    ->first()->user->name
            );
        }
    }
}
