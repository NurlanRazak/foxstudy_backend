<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Vacancy;
use App\Models\Question;
use App\Models\Option;

/**
 * Class QuestionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class QuestionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Question::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/question');
        $this->crud->setEntityNameStrings(trans_choice('admin.question', 1), trans('admin.question_big'));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'vacancies',
                'label' => trans_choice('admin.vacancy', 2),
                'type' => 'select_multiple',
                'entity' => 'vacancies',
                'attribute' => 'name',
                'model' => Vacancy::class
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Question::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(QuestionRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'title',
                'label' => trans('admin.question'),
                'type' => 'ckeditor',
                'fake' => true,
                'store_in' => 'extras',
            ],
            [
                'name' => 'vacancies',
                'label' => trans_choice('admin.vacancy', 2),
                'type' => 'select2_multiple',
                'entity' => 'vacancies',
                'attribute' => 'name',
                'pivot' => true,
                'model' => Vacancy::class,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            // [
            //     'name' => 'options',
            //     'label' => trans_choice('admin.option', 2),
            //     'type' => 'select2_multiple',
            //     'entity' => 'options',
            //     'attribute' => 'option',
            //     'model' => Option::class,
            // ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Question::getStatusOptions(),
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
}
