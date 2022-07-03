<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Echange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EchangesController extends Controller
{
    public function initier(Request $request){
        // Contrat
        $contrat = Contrat::findOrFail($request->contrat_id);

        //Nouveau Echange
        $echange = new Echange();
        $echange->etape = 1;
        $echange->sens = "->";
        $echange->expediteur = backpack_user()->name;
        $echange->destinataire = $contrat->affaire->division->user->name;
        $echange->date_exp = date("Y-m-d");

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->file && request()->file->isValid()) {
            // 1. Generate a new file name
            $file = request()->file;
            $new_file_name = date("Y-m-d_H_i_s").'_'.$file->getClientOriginalName();

            // 2. Move the new file to the correct path
            $disk = "public";
            $destination_path = "/";
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $echange->fichier = $file_path;
        }else{
            $echange->fichier = "erreur";
        }

        $echange->commentaire = $request->commentaire;
        $echange->contrat_id = $request->contrat_id;

        $echange->save();

        return "OK";
    }

    public function e2_valider(Request $request){
        //Mettre à jour ancien Echange
        $a_echange = Echange::findOrFail($request->echange_id);
        $a_echange->date_cloture = date("Y-m-d");
        $a_echange->save();

        //Nouveau Echange
        $echange = new Echange();
        $echange->etape = 3;
        $echange->sens = "->";
        $echange->expediteur = backpack_user()->name;
        $echange->destinataire = backpack_user()->division->pole->user->name;
        $echange->date_exp = date("Y-m-d");

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->file && request()->file->isValid()) {
            // 1. Generate a new file name
            $file = request()->file;
            $new_file_name = date("Y-m-d_H_i_s").'_'.$file->getClientOriginalName();

            // 2. Move the new file to the correct path
            $disk = "public";
            $destination_path = "/";
            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

            // 3. Save the complete path to the database
            $echange->fichier = $file_path;
        }else{
            $echange->fichier = "erreur";
        }

        $echange->commentaire = $request->commentaire;
        $echange->contrat_id = $a_echange->contrat_id;

        $echange->save();

        return "OK";
    }

    public function e2_rejeter(Request $request){
        //Mettre à jour ancien Echange
        $a_echange = Echange::findOrFail($request->echange_id);
        $a_echange->date_cloture = date("Y-m-d");
        $a_echange->save();

        //Nouveau Echange
        $echange = new Echange();
        $echange->etape = 1;
        $echange->sens = "<-";
        $echange->expediteur = backpack_user()->name;
        $echange->destinataire = $a_echange->expediteur;
        $echange->date_exp = date("Y-m-d");
        $echange->commentaire = $request->commentaire;
        $echange->contrat_id = $a_echange->contrat_id;

        $echange->save();

        return "OK";
    }
}
