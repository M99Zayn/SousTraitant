<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AffaireRequest;
use App\Models\Affaire;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Request;

/**
 * Class AffaireCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AffaireCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Affaire::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/affaire');
        CRUD::setEntityNameStrings('affaire', 'affaires');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(strcmp(backpack_user()->role, "Admin")!=0 AND strcmp(backpack_user()->role, "Cadre administrative")!=0){
            $this->crud->removeButton('create');
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('delete');
        }
        if(strcmp(backpack_user()->role, "Chef de projet")==0){
            $this->crud->addClause('where', 'user_id', backpack_user()->id);
        }
        else if(strcmp(backpack_user()->role, "Chef de division")==0){
            $this->crud->addClause('where', 'division_id', backpack_user()->division);
        }else if(strcmp(backpack_user()->role, "Directeur de pole")==0){
            $this->crud->addClause('whereIn', 'division_id', backpack_user()->DivisionsIds);
        }else if(strcmp(backpack_user()->role, "Cadre administrative")==0){
            $this->crud->addClause('whereIn', 'division_id', backpack_user()->DivisionsIds);
        }
        CRUD::column('code');
        CRUD::column('objet');
        CRUD::column('user_id');
        CRUD::column('division_id');

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
        CRUD::setValidation(AffaireRequest::class);

        CRUD::field('code');
        CRUD::field('objet');
        CRUD::field('user_id');
        CRUD::field('division_id');

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
        $affaire = Affaire::findOrFail(Request::segment(3));

        CRUD::addColumn([
            'name'     => 'my_custom_html',
            'label'    => 'Contrats',
            'type'     => 'custom_html',
            'value'    => '<a href="'.route('listcontrats', $affaire->id).'">Afficher les contrats</a>',

            // OPTIONALS
            // 'escaped' => true // echo using {{ }} instead of {!! !!}
        ]);
        if(strcmp(backpack_user()->role, "Admin")!=0 AND strcmp(backpack_user()->role, "Cadre administrative")!=0){
            $this->crud->removeButton( 'update' );
            $this->crud->removeButton( 'delete' );
        }
    }
}
