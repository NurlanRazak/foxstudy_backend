<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CourseRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Course;
use App\Models\Subcategory;

/**
 * Class CourseCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CourseCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Course::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/course');
        $this->crud->setEntityNameStrings(trans_choice('admin.course', 1), trans_choice('admin.course', 2));
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
                'disk' => 'uploads',
                'width' => '150px',
                'height' => '150px',
            ],
            [
                'name' => 'short_description',
                'label' => trans('admin.short_description'),
                'limit' => 200,
            ],
            [
                'name' => 'subcategory_id',
                'label' => trans_choice('admin.subcategory', 2),
                'type' => 'select',
                'entity' => 'subcategory',
                'attribute' => 'name',
                'model' => Subcategory::class,
            ],
            [
                'name' => 'rating',
                'label' => trans('admin.rating'),
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Course::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CourseRequest::class);

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
                'disk' => 'uploads',
            ],
            [
                'name' => 'images',
                'label' => trans('admin.images'),
                'type' => 'upload_multiple',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'short_description',
                'label' => trans('admin.short_description'),
                'type' => 'textarea',
            ],
            [
                'name' => 'long_description',
                'label' => trans('admin.long_description'),
                'type' => 'ckeditor',
            ],
            [
                'name' => 'subcategory_id',
                'label' => trans_choice('admin.subcategory', 2),
                'type' => 'select2',
                'entity' => 'subcategory',
                'attribute' => 'name',
                'model' => Subcategory::class,
            ],
            [
                'name' => 'longitude',
                'label' => trans('admin.longitude'),
                'type' => 'text',
                'fake' => true,
                'store_in' => 'map',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'latitude',
                'label' => trans('admin.latitude'),
                'type' => 'text',
                'fake' => true,
                'store_in' => 'map',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'at_morning',
                'label' => trans('admin.at_morning'),
                'type' => 'textarea',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'at_afternoon',
                'label' => trans('admin.at_afternoon'),
                'type' => 'textarea',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'at_evening',
                'label' => trans('admin.at_evening'),
                'type' => 'textarea',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'trial',
                'label' => trans('admin.trial'),
                'type' => 'select_from_array',
                'options' => Course::getTrialOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'name' => 'rating',
                'label' => trans('admin.rating'),
                'type' => 'text',
                'suffix' => ' %',
                'hint' => trans('admin.hint_rating'),
                'attributes' => [
                    'disabled' => 'disabled',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Course::getStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4',
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
