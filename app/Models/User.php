<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'matricule',
        'name',
        'email',
        'role',
        'password',
        'user_id',
        'division_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    function getDivisionsIdsAttribute(){
        if(strcmp(backpack_user()->role, "Directeur de pole")==0){
            $poles = Pole::where('user_id', backpack_user()->id)->get();
            $ids = [];
            foreach ($poles as $pole){
                $divions = $pole->divisions;
                foreach ($divions as $div){
                    $ids[] = $div->id;
                }
            }
            return $ids;
        }else if (strcmp(backpack_user()->role, "Cadre administrative")==0){
            $divions = $this->division->pole->divisions;
            $ids = [];
            foreach ($divions as $div){
                $ids[] = $div->id;
            }
            return $ids;
        }
      }
}
