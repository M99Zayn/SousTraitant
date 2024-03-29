<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SoustraitantRequest;
use App\Models\Soustraitant;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Request;
/**
 * Class SoustraitantCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SoustraitantCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Soustraitant::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/soustraitant');
        CRUD::setEntityNameStrings('soustraitant', 'soustraitants');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('identifiant');
        CRUD::column('raison_sociale');
        CRUD::column('addresse');
        CRUD::column('telephone');
        CRUD::column('email');
        CRUD::column('domaine');
        CRUD::column('date_anciennete')->label('Date début d’exercice');
        CRUD::column('patente');
        CRUD::column('commentaire');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SoustraitantRequest::class);

        CRUD::field('identifiant');
        CRUD::field('raison_sociale');
        CRUD::field('addresse');
        CRUD::field('telephone');
        CRUD::field('email');
        CRUD::field('domaine');
        CRUD::field('date_anciennete');
        CRUD::field('patente');
        CRUD::field('commentaire');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        $soustrait = Soustraitant::findOrFail(Request::segment(3));

        CRUD::addColumn([
            'name'     => 'my_custom_html',
            'label'    => 'Contrats',
            'type'     => 'custom_html',
            'value'    => '<a href="'.route('soustraitant_contrats', $soustrait->id).'">Afficher les contrats</a>',

            // OPTIONALS
            // 'escaped' => true // echo using {{ }} instead of {!! !!}
        ]);

    }
}
