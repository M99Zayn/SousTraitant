<?php

use App\Http\Controllers\EchangesController;
use App\Http\Controllers\ContratsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('initier', [EchangesController::class,'initier']); //Initier un échange
Route::post('valider', [EchangesController::class,'valider']); //Valider
Route::post('rejeter', [EchangesController::class,'rejeter']); //Rejeter

Route::get('contrats/{affaire}', [ContratsController::class,'contrats'])->name('listcontrats'); //Contrats par affaire
Route::get('contrats/{sstr}', [ContratsController::class,'soustraitant_contrats'])->name('soustraitant_contrats'); //Contrats par sous traitant

Route::get('echanges/{contrat}', [EchangesController::class,'contrat_echanges'])->name('contrat_echanges'); //Echange par contrat
