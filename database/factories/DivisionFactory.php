<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Division;
use App\Models\Pole;
use App\Models\User;

class DivisionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Division::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $abr = $this->faker->word;
        return [
            'abreviation' => $abr,
            'designation' => $abr.$this->faker->lexify('????'),
            'pole_id' => Pole::factory(),
            'user_id' => User::factory(),
        ];
    }
}
