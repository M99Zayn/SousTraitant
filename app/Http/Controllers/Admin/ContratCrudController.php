<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContratRequest;
use App\Models\Contrat;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Request;
use Backpack\CRUD\app\Library\Widget;

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
        if(strcmp(backpack_user()->role, "Admin")!=0 AND strcmp(backpack_user()->role, "Service marché")!=0){
            $this->crud->removeButton('create');
        }
        if(strcmp(backpack_user()->role, "Admin")!=0){
            $this->crud->denyAccess('update');
            $this->crud->denyAccess('delete');
        }

        CRUD::column('identifiant');
        CRUD::column('type');
        CRUD::addColumn(['label' => 'Contrat racine', 'type' => 'select',
        'name' => 'contrat_id', 'entity' => 'contrat', 'attribute' => 'identifiant', 'model' => "App\Models\Contrat"]);
        CRUD::column('date_signature');
        CRUD::column('objet');
        CRUD::column('montant');
        CRUD::column('duree')->label('Durée en mois');
        CRUD::column('date_debut');
        CRUD::column('date_fin');
        CRUD::addColumn(['name' => 'statut', 'type' => 'select_from_array', 'options' => [0 => 'En cours', 1 => 'Cloturé']]);
        CRUD::addColumn(['label' => 'Sous traitant', 'type' => 'select', 'name' => 'soustraitant_id', 'entity' => 'soustraitant',
        'attribute' => 'identifiant', 'model' => "App\Models\Soustraitant", 'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('soustraitant/'.$related_key.'/show');
                },
                'target' => '_blank',
            ],
        ]);
        CRUD::addColumn(['label' => 'Affaire', 'type' => 'select', 'name' => 'affaire_id', 'entity' => 'affaire',
        'attribute' => 'code', 'model' => "App\Models\Affaire", 'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('affaire/'.$related_key.'/show');
                },
                'target' => '_blank',
            ],
        ]);

        // <a href="/app/echange/{{ $e->id }}/show">Afficher</a>

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
        CRUD::field('type')->type('select_from_array')->options([
            "Contrat"=>"Contrat",
            "Avenant"=>"Avenant"])->allows_null(false);
        CRUD::field('contrat_id')->label("Contrat si avenant");
        CRUD::field('date_signature');
        CRUD::field('objet');
        CRUD::field('montant');
        CRUD::field('duree')->label("Durée en mois");
        CRUD::field('date_debut');
        CRUD::field('date_fin');
        CRUD::field('soustraitant_id')->label("Sous Traitant");
        CRUD::field('affaire_id');
        CRUD::field('statut')->type('hidden')->value(0);

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
        if(strcmp(backpack_user()->role, "Admin")!=0 AND strcmp(backpack_user()->role, "Chef de projet")!=0){
            $this->crud->removeButton( 'update' );
            $this->crud->removeButton( 'delete' );
        }
        $this->setupListOperation();
        $contrat = Contrat::findOrFail(Request::segment(3));
        if(backpack_user()->role == "Chef de projet"){
            if ($contrat->statut == 0){
                if($contrat->echanges->count() == 0){
                    Widget::add([
                        'type'        => 'view',
                        'view'        => 'Initier',
                        'contrat_id'  =>  $contrat->id,
                        'echange_id'  =>  NULL,
                    ]);
                }
            }
        }
        CRUD::addColumn([
            'name'     => 'my_custom_html',
            'label'    => 'Echanges',
            'type'     => 'custom_html',
            'value'    => '<a href="'.route('contrat_echanges', $contrat->id).'">Afficher les échanges</a>',

            // OPTIONALS
            // 'escaped' => true // echo using {{ }} instead of {!! !!}
        ]);
    }
}
