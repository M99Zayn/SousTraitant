<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Contrat;
use App\Models\Echange;

class EchangeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Echange::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'etape' => $this->faker->randomElement(["1","2","3","4","5","6"]),
            'sens' => $this->faker->word,
            'expediteur' => $this->faker->word,
            'destinataire' => $this->faker->word,
            'date_exp' => $this->faker->date(),
            'date_cloture' => $this->faker->date(),
            'fichier' => $this->faker->word,
            'commentaire' => $this->faker->text,
            'contrat_id' => Contrat::factory(),
        ];
    }
}
