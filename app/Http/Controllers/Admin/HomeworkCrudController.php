<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HomeworkRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Lesson;
use App\Models\Homework;
use App\User;


/**
 * Class HomeworkCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HomeworkCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Homework');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/homework');
        $this->crud->setEntityNameStrings(trans_choice('admin.homeworks',1), trans_choice('admin.homeworks', 2));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
            ],
            [
                'name' => 'lesson_id',
                'label' => trans_choice('admin.lesson',2),
                'type' => 'select',
                'entity' => 'lesson',
                'attribute' => 'name',
                'model' => Lesson::class,
            ],
            [
                'name' => 'user_id',
                'label' => trans('admin.user'),
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => User::class,
            ],
            [
                'name' => 'deadline_at',
                'label' => trans('admin.deadline_at'),
                'type' => 'date',
                'format' => 'l H:m:s',
            ],
            [
                'name' => 'grade',
                'label' => trans('admin.grade'),
            ],
            [
                'name' => 'file',
                'label' => trans('admin.file'),
                'type' => 'model_function',
                'function_name' => 'getFileUrl',
                'limit' => 100,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Homework::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(HomeworkRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'description',
                'label' => trans('admin.description'),
                'type' => 'ckeditor',
            ],
            [
                'name' => 'file',
                'label' => trans('admin.file'),
                'type' => 'upload',
                'upload' => true,
                'disk' => 'uploads',
            ],
            [
                'name' => 'lesson_id',
                'label' => trans_choice('admin.lesson',2),
                'type' => 'select2',
                'entity' => 'lesson',
                'attribute' => 'name',
                'model' => Lesson::class,
            ],
            [
                'name' => 'user_id',
                'label' => trans('admin.user'),
                'type' => 'select2',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => User::class,
            ],
            [
                'name' => 'grade',
                'label' => trans('admin.grade'),
                'type' => 'number',
            ],
            [   // DateTime
                'name'  => 'deadline_at',
                'label' => trans('admin.deadline_at'),
                'type'  => 'datetime',
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Homework::getStatusOptions(),
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
