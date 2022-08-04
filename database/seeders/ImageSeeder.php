<?php

namespace Database\Seeders;

use App\Models\Example\Image;
use App\Models\Example\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Queue\Failed\NullFailedJobProvider;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default Demo User
        Image::factory()->create([
            'name' => 'Ressource_Image_Routes.png',
            'path' => '',
            'person_id' => Person::where('username', 'laraveller')->first(),
            'user_id' => User::where('email', 'fdsdwp@protonmail.com')->first(),
            'upload_time' => now(),
            'update_time' => now(),
            'remove_time' => null,
        ]);
    }
}
