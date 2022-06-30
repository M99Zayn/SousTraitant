<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
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
        'type',
        'date_signature',
        'objet',
        'montant',
        'duree',
        'date_debut',
        'date_fin',
        'statut',
        'soustraitant_id',
        'affaire_id',
        'contrat_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_signature' => 'date',
        'montant' => 'float',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'statut' => 'boolean',
        'soustraitant_id' => 'integer',
        'affaire_id' => 'integer',
        'contrat_id' => 'integer',
    ];

    public function soustraitant()
    {
        return $this->belongsTo(Soustraitant::class);
    }

    public function affaire()
    {
        return $this->belongsTo(Affaire::class);
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
    public function echanges()
    {
        return $this->hasMany(Echange::class);
    }
}
