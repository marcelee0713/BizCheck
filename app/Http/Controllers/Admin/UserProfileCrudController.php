<?php

namespace App\Http\Controllers\Admin;

use App\Constants\BusinessModels;
use App\Constants\Industries;
use App\Http\Requests\UserProfileRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserProfileCrudController extends CrudController
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
        CRUD::setModel(\App\Models\UserProfile::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user-profile');
        CRUD::setEntityNameStrings('user profile', 'user profiles');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        CRUD::column('business_name')->type('string');
        CRUD::column('id')->type('string');
        CRUD::column('business_model');
        CRUD::column('industry');
        CRUD::column('user_id')->wrapper([
            'href' => function ($crud, $column, $entry) {
                return backpack_url('user/' . $entry->user_id . '/show');
            }
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserProfileRequest::class);
        CRUD::field([
            'label' => 'User',
            'type' => 'select',
            'name' => 'user_id',
            'model' => 'App\Models\User',
            'attribute' => 'email',
            'options' => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
        ]);

        CRUD::setFromDb();


        CRUD::field([
            'name'  => 'business_model',
            'label' => 'Business Model',
            'type' => 'select_from_array',
            'options'     => BusinessModels::MODELS_KV,
            'allows_null' => false,
        ]);

        CRUD::field([
            'name'  => 'industry',
            'label' => 'Industry',
            'type' => 'select_from_array',
            'options'     => Industries::INDUSTRIES_KV,
            'allows_null' => false,
        ]);
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
        CRUD::field('updated_at')->type('datetime');
        CRUD::field('created_at')->type('datetime');
    }
}
