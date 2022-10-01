<?php

namespace App\Http\Controllers;

use App\Models\Contrat;
use App\Models\Echange;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EchangesController extends Controller
{
    public function initier(Request $request){
        //Nouveau Echange
        $echange = new Echange();
        $echange->etape = 2;
        $echange->sens = "->";
        $echange->expediteur = backpack_user()->name;
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

        //Cas 1 : Nouvelle initiation:
        if($request->contrat_id != NULL){
            // Contrat
            $contrat = Contrat::findOrFail($request->contrat_id);

            $echange->destinataire = $contrat->affaire->division->user->name;
            $echange->contrat_id = $request->contrat_id;

        //Cas 2 : Initiation après rejet:
        }else if($request->echange_id != NULL){
            //Mettre à jour ancien Echange
            $a_echange = Echange::findOrFail($request->echange_id);
            $a_echange->date_cloture = date("Y-m-d");
            $a_echange->save();

            $echange->destinataire = $a_echange->contrat->affaire->division->user->name;
            $echange->contrat_id = $a_echange->contrat_id;
        }
        $echange->save();
        return "OK";
    }

    public function valider(Request $request){
        //Mettre à jour ancien Echange
        $a_echange = Echange::findOrFail($request->echange_id);
        $a_echange->date_cloture = date("Y-m-d");
        $a_echange->save();

        //Nouveau Echange
        $echange = new Echange();
        $echange->sens = "->";
        $echange->expediteur = backpack_user()->name;
        $echange->date_exp = date("Y-m-d");

        /*
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
        */

        $echange->fichier = $a_echange->fichier;
        $echange->commentaire = $request->commentaire;
        $echange->contrat_id = $a_echange->contrat_id;

        if($a_echange->etape == 2){
            $echange->etape = 3;
            $echange->destinataire = backpack_user()->division->pole->user->name;
        }else if($a_echange->etape == 3){
            $echange->etape = 4;
            $dcg = User::where('role', 'Division controle de gestion')->first();
            if($dcg != NULL){
                $echange->destinataire = $dcg->name;
            }else abort(403,'dcg introuvable');
        }

        $echange->save();

        return "OK";
    }

    public function rejeter(Request $request){
        //Mettre à jour ancien Echange
        $a_echange = Echange::findOrFail($request->echange_id);
        $a_echange->date_cloture = date("Y-m-d");
        $a_echange->save();

        //Nouveau Echange
        $echange = new Echange();
        $echange->etape = $a_echange->etape-1;

        //
        $echange->destinataire = $a_echange->contrat->echanges->where('etape',$a_echange->etape)
                                ->where('sens','->')->first()->expediteur;
        $echange->sens = "<-";
        $echange->expediteur = backpack_user()->name;
        $echange->date_exp = date("Y-m-d");
        $echange->fichier = $a_echange->fichier;
        $echange->commentaire = $request->commentaire;
        $echange->contrat_id = $a_echange->contrat_id;

        $echange->save();

        return "OK";
    }

    public function contrat_echanges(Request $request, Contrat $contrat){
        $echanges = $contrat->echanges()->orderBy('created_at', 'desc')->get();
        return view('Contrat_echanges', compact('echanges'));
    }
}
