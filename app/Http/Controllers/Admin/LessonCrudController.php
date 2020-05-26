<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LessonRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Course;
use App\Models\Lesson;
/**
 * Class LessonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LessonCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Lesson::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/lesson');
        $this->crud->setEntityNameStrings(trans_choice('admin.lesson', 1), trans_choice('admin.lesson', 2));
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
                'height' => 'auto',
            ],
            [
                'name' => 'course_id',
                'label' => trans_choice('admin.course', 2),
                'type' => 'select',
                'entity' => 'course',
                'attribute' => 'name',
                'model' => Course::class,
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Lesson::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(LessonRequest::class);

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
                'name' => 'video',
                'label' => trans('admin.video'),
                'type' => 'upload',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'textarea',
            ],
            [
                'name' => 'content',
                'label' => trans('admin.content'),
                'type' => 'ckeditor',
            ],
            [
                'name' => 'course_id',
                'label' => trans_choice('admin.course', 2),
                'type' => 'select2',
                'entity' => 'course',
                'attribute' => 'name',
                'model' => Course::class,
                'wrapperAttribute' => [
                    'class' => 'form-group col-sm-6',
                ],
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Lesson::getStatusOptions(),
                'wrapperAttribute' => [
                    'class' => 'form-group col-sm-6',
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
