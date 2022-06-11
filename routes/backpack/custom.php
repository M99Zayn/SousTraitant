<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('affaire', 'AffaireCrudController');
    Route::crud('contrat', 'ContratCrudController');
    Route::crud('division', 'DivisionCrudController');
    Route::crud('echange', 'EchangeCrudController');
    Route::crud('pole', 'PoleCrudController');
    Route::crud('soustraitant', 'SoustraitantCrudController');
    Route::crud('user', 'UserCrudController');
}); // this should be the absolute last line of this file