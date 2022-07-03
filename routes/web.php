<?php

use App\Http\Controllers\EchangesController;
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
Route::post('e2_valider', [EchangesController::class,'e2_valider']); //Valider étape 2
Route::post('e2_rejeter', [EchangesController::class,'e2_rejeter']); //Rejeter étape 2
