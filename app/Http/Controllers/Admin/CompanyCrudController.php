<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Company;

/**
 * Class CompanyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        $this->crud->setModel(Company::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/company');
        $this->crud->setEntityNameStrings(trans_choice('admin.company', 1), trans_choice('admin.company', 2));
        $this->crud->addClause('orderBy', 'lft');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'prefix' => 'uploads/',
                'width' => '150px',
                'height' => '150px',
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'limit' => 200,
            ],
            [
                'name' => 'link',
                'label' => trans('admin.link'),
                'type' => 'model_function',
                'function_name' => 'getLink',
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Company::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CompanyRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
                'type' => 'textarea',
            ],
            [
                'name' => 'address',
                'label' => trans('admin.address'),
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'ckeditor',
            ],
            [
                'name' => 'fields',
                'label' => trans('admin.activity_fields'),
                'type' => 'table',
                'entity_singular' => 'option',
                'columns' => [
                    'name' => trans('admin.name')
                ],
            ],
            [
                'name' => 'link',
                'label' => trans('admin.link'),
                'type' => 'text',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Company::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', 'name');
        $this->crud->set('reorder.max_level', 1);
    }
}
