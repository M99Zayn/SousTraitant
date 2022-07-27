<?php

namespace App\Http\Controllers;

use App\Models\Affaire;
use App\Models\Contrat;
use Illuminate\Http\Request;

class ContratsController extends Controller
{
    public function contrats(Request $request, Affaire $affaire){
        $contrats = $affaire->contrats()->get();
        return view('Affaire_contrats', compact('contrats'));
    }
}
