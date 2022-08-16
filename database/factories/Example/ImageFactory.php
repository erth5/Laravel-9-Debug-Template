<?php

namespace Database\Factories\Example;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Example\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'path' => 'image',
            'name' => 'name',
            'extension' => null,
            // $this->faker->image('https://source.unsplash.com/random'); TODO
            // 'image' => 'https://source.unsplash.com/random',
        ];
    }
}
