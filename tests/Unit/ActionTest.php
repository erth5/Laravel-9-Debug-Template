<?php

namespace Tests\Unit;

use App\Actions\CallAdjust;
use App\Models\Example\Person;
use App\Models\User;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class ActionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $unadjustedPerson = Person::factory()->create([
            'user_id' => $user = User::factory()->create([
                'name' => 'Viola Rett',
                'email' => 'xzm07930@xcoxc.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'remember_token' => token_name(10)
            ])->first(),
            'surname' => 'Lord',
            'last_name' => 'Kennedy',
            'username' => 'laraveller',
        ])->saveOrFail();
        $Adjusting = new CallAdjust;
        $Adjusting->handle();
        assertEquals(
            'LordKennedy',
            Person::where('email', 'xzm07930@xcoxc.com')
                ->first()->user->name
        );
    }
}
