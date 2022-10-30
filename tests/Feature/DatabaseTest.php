<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Example\Person;
use Database\Seeders\PersonSeeder;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\assertEquals;
use App\Http\Controllers\Example\PersonController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class DatabaseTest extends TestCase
{
    /** Migriert vor dem Test, Entfernt alles nach dem Test */
    // use DatabaseMigrations;

    /** Migriert vor und nach dem Test */
    // use RefreshDatabase;

    /** fuer SQLite, Speichert den Zustand zwischen und stellt ihn wieder her */
    use DatabaseTransactions;

    /** Setzt die Authentifizierung und andere Middlewares außer Kraft */
    // use WithoutMiddleware;

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_user_name()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed('PersonSeeder');
            $this->seed('UserSeeder');
        }
        $defaultUser = User::where('name', "=", 'Max Mustermann')->first();

        // Nicht funktionsfähig
        // $defaultUser = User::findOrFail(1)->first();

        $this->assertEquals('Max Mustermann', $defaultUser->name);
    }

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_person_username()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed(PersonSeeder::class);
        }
        $defaultPerson = Person::where('username', "=", 'laraveller')->first();
        $this->assertEquals("laraveller", $defaultPerson->username);
    }

    /**
     * Teste, dass der Entwicklungs-Standard Eintrag vorhanden ist.
     * @group data
     * @return void
     */
    public function test_db_default_person_last_name()
    {
        if (DB::table('people')->count() == 0)
            $this->seed('PersonSeeder');
        $this->assertDatabaseHas('people', [
            'last_name' => 'Mustermann',
        ]);
    }

    /**
     * Teste ob ein Nutzer angelegt werden kann
     * Testet nicht auf Basis von softDeletes
     * @group data
     * @return void
     */
    public function test_db_can_create_and_delete_user()
    {
        $user = User::factory()->create();
        $this->assertModelExists($user);
        $user->forceDelete();
        $this->assertModelMissing($user);
    }

    /**
     * set users name to surname and last name from person .
     *
     * @return void
     */
    public function test_can_adjust_person()
    {
        if (DB::table('people')->count() == 0) {
            $this->seed('PersonSeeder');
        }
        $adjusting = (new PersonController)->adjust();
        assertEquals(
            'Lord Kennedy',
            Person::where('username', 'thespasst')
                ->first()->user->name
        );
    }
}
