<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubcategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Subcategory;
use App\Models\Category;

/**
 * Class SubcategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubcategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    public function setup()
    {
        $this->crud->setModel(Subcategory::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subcategory');
        $this->crud->setEntityNameStrings(trans_choice('admin.subcategory', 1), trans_choice('admin.subcategory', 2));
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
                'name' => 'category_id',
                'label' => trans_choice('admin.category', 2),
                'type' => 'select',
                'entity' => 'category',
                'attribute' => 'name',
                'model' => Category::class,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Subcategory::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(SubcategoryRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'image',
                'label' => trans('admin.image'),
                'type' => 'image',
                'upload' => true,
                'crop' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'category_id',
                'label' => trans_choice('admin.category', 2),
                'type' => 'select2',
                'entity' => 'category',
                'attribute' => 'name',
                'model' => Category::class
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Subcategory::getStatusOptions(),
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
