<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContratRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContratCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContratCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Contrat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contrat');
        CRUD::setEntityNameStrings('contrat', 'contrats');
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
        CRUD::column('type');
        CRUD::column('date_signature');
        CRUD::column('objet');
        CRUD::column('montant');
        CRUD::column('duree');
        CRUD::column('date_debut');
        CRUD::column('date_fin');
        CRUD::column('statut');
        CRUD::column('soustraitant_id');
        CRUD::column('affaire_id');
        CRUD::column('contrat_id');

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
        CRUD::setValidation(ContratRequest::class);

        CRUD::field('identifiant');
        CRUD::field('type');
        CRUD::field('date_signature');
        CRUD::field('objet');
        CRUD::field('montant');
        CRUD::field('duree');
        CRUD::field('date_debut');
        CRUD::field('date_fin');
        CRUD::field('statut');
        CRUD::field('soustraitant_id');
        CRUD::field('affaire_id');
        CRUD::field('contrat_id');

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
}
