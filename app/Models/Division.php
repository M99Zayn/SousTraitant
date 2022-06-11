<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abreviation',
        'designation',
        'pole_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pole_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function pole()
    {
        return $this->belongsTo(Pole::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
