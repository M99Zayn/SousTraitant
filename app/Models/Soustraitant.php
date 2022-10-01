<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soustraitant extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identifiant',
        'raison_sociale',
        'addresse',
        'telephone',
        'email',
        'domaine',
        'date_anciennete',
        'patente',
        'commentaire',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_anciennete' => 'date',
        'patente' => 'boolean',
    ];

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
