<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FeedbackRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FeedbackCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FeedbackCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Feedback');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/feedback');
        $this->crud->setEntityNameStrings(trans_choice('admin.feedback',1), trans_choice('admin.feedback',2));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'label' => '#',
                'type' => 'row_number',
            ],
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
            ],
            [
                'name' => 'email',
                'label' => 'Email',
            ],
            [
                'name' => 'comments',
                'label' => trans('admin.comments'),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(FeedbackRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'comments',
                'label' => trans('admin.comments'),
                'type' => 'textarea',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
