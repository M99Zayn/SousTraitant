<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Echange extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'etape',
        'sens',
        'expediteur',
        'destinataire',
        'date_exp',
        'date_cloture',
        'fichier',
        'commentaire',
        'contrat_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_exp' => 'date',
        'date_cloture' => 'date',
        'contrat_id' => 'integer',
    ];

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }

    // public function setFichierAttribute($value)
    // {
    //     $attribute_name = "fichier";
    //     $disk = "public";
    //     $destination_path = "/";
    //     // if a new file is uploaded, delete the file from the disk
    //     if (request()->hasFile($attribute_name) &&
    //         $this->{$attribute_name} &&
    //         $this->{$attribute_name} != null) {
    //         Storage::disk($disk)->delete($this->{$attribute_name});
    //         $this->attributes[$attribute_name] = null;
    //     }

    //     // if the file input is empty, delete the file from the disk
    //     if (is_null($value) && $this->{$attribute_name} != null) {
    //         Storage::disk($disk)->delete($this->{$attribute_name});
    //         $this->attributes[$attribute_name] = null;
    //     }

    //     // if a new file is uploaded, store it on disk and its filename in the database
    //     if (request()->hasFile($attribute_name) && request()->file($attribute_name)->isValid()) {
    //         // 1. Generate a new file name
    //         $file = request()->file($attribute_name);
    //         $new_file_name = date("Y-m-d_H_i_s").'_'.$file->getClientOriginalName();

    //         // 2. Move the new file to the correct path
    //         $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

    //         // 3. Save the complete path to the database
    //         $this->attributes[$attribute_name] = $file_path;
    //     }
    // }
}
