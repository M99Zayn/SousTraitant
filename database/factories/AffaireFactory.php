<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Affaire;
use App\Models\Division;
use App\Models\User;

class AffaireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Affaire::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomDigit(),
            'objet' => $this->faker->word,
            'user_id' => User::factory(),
            'division_id' => Division::factory(),
        ];
    }
}
