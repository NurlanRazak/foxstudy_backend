<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StaffRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Staff;

/**
 * Class StaffCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class StaffCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Staff::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/staff');
        $this->crud->setEntityNameStrings(trans_choice('admin.staff', 1), trans_choice('admin.staff', 2));
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
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
            ],
            // [
            //     'name' => 'about',
            //     'label' => trans('admin.about'),
            // ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(StaffRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'email',
                'label' => trans('admin.email'),
            ],
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
            ],
            // [
            //     'name' => 'about',
            //     'label' => trans('admin.about'),
            // ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
