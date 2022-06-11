<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Soustraitant;

class SoustraitantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Soustraitant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifiant' => $this->faker->word,
            'raison_sociale' => $this->faker->word,
            'addresse' => $this->faker->word,
            'telephone' => $this->faker->word,
            'email' => $this->faker->safeEmail,
            'domaine' => $this->faker->word,
            'date_anciennete' => $this->faker->date(),
            'patente' => $this->faker->boolean,
            'commentaire' => $this->faker->text,
        ];
    }
}
