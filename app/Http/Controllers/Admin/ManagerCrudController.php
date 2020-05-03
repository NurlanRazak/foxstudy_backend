<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ManagerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ManagerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ManagerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Manager');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manager');
        $this->crud->setEntityNameStrings(trans_choice('admin.managers',1), trans_choice('admin.managers',2));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'email',
                'label' => trans('admin.email'),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ManagerRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
                'attributes' => [
                    'required' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
            [
                'name' => 'email',
                'label' => trans('admin.email'),
                'type' => 'email',
                'attributes' => [
                    'required' => true,
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12 required',
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
