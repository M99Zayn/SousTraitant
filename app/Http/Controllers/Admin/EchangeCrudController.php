<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EchangeRequest;
use App\Models\Echange;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Request;
use Backpack\CRUD\app\Library\Widget;

/**
 * Class EchangeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EchangeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Echange::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/echange');
        CRUD::setEntityNameStrings('echange', 'echanges');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if(backpack_user()->role!='Admin'){
            $this->crud->addClause('where', 'destinataire', backpack_user()->name)
                ->orWhere('expediteur', backpack_user()->name);
        }
        CRUD::column('etape');
        CRUD::column('sens');
        CRUD::column('expediteur');
        CRUD::column('destinataire');
        CRUD::column('date_exp');
        CRUD::column('date_cloture');
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
        CRUD::setValidation(EchangeRequest::class);

        CRUD::field('etape')->type('enum');
        CRUD::field('sens');
        CRUD::field('expediteur');
        CRUD::field('destinataire');
        CRUD::field('date_exp');
        CRUD::field('date_cloture');
        CRUD::field('fichier');
        CRUD::field('commentaire');
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

    protected function setupShowOperation()
    {
        CRUD::addColumn('etape');
        CRUD::addColumn('sens');
        CRUD::addColumn('expediteur');
        CRUD::addColumn('destinataire');
        CRUD::addColumn('date_exp');
        CRUD::addColumn('date_cloture');
        CRUD::addColumn(
            [   // Upload
                'label'     => 'Fichier',
                'type'      => 'upload',
                'name'      => 'fichier', // the db column for the foreign key
                'wrapper'   => [
                    'element' => 'a', // the element will default to "a" so you can skip it here
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return '/storage/'.Echange::findOrFail($entry->id)->fichier;
                    },
                    'target' => '_blank',
                    // 'class' => 'some-class',
                ],
            ]
        );
        CRUD::addColumn('commentaire');
        $echange = Echange::findOrFail(Request::segment(3));
        if(backpack_user()->role == "Chef de projet"){
            if ($echange->etape == 1 AND $echange->sens == "<-" AND $echange->date_cloture == NULL){
                Widget::add([
                    'type'        => 'view',
                    'view'        => 'Initier',
                    'echange_id'  =>  $echange->id,
                    'contrat_id'  =>  NULL,
                ]);
            }
        }
        if(backpack_user()->role == "Chef de division"){
            if ($echange->etape == 1 AND $echange->date_cloture == NULL AND $echange->sens == "->"){
                Widget::add([
                    'type'        => 'view',
                    'view'        => 'Etape2_Valider',
                    'id'          =>  $echange->id,
                ]);
            }
        }
    }
}
