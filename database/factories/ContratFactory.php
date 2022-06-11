<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Affaire;
use App\Models\Contrat;
use App\Models\Soustraitant;

class ContratFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contrat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'identifiant' => $this->faker->word,
            'type' => $this->faker->randomElement(["Contrat","Avenant"]),
            'date_signature' => $this->faker->date(),
            'objet' => $this->faker->word,
            'montant' => $this->faker->randomFloat(0, 0, 9999999999.),
            'duree' => $this->faker->numberBetween(-10000, 10000),
            'date_debut' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
            'statut' => $this->faker->boolean,
            'soustraitant_id' => Soustraitant::factory(),
            'affaire_id' => Affaire::factory(),
            'contrat_id' => Contrat::factory(),
        ];
    }
}
