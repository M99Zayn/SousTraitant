<?php

namespace App\Http\Controllers;

use App\Models\Affaire;
use App\Models\Contrat;
use App\Models\Soustraitant;
use Illuminate\Http\Request;

class ContratsController extends Controller
{
    public function contrats(Request $request, Affaire $affaire){
        $contrats = $affaire->contrats()->get();
        return view('Affaire_contrats', compact('contrats'));
    }

    public function soustraitant_contrats(Request $request, Soustraitant $st){
        $contrats = $st->contrats()->get();
        return view('soustraitant_contrats', compact('contrats'));
    }
}
