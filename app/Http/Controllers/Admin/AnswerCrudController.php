<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AnswerRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;


class AnswerCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Answer::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/answer');
        $this->crud->setEntityNameStrings(trans_choice('admin.answer', 1), trans_choice('admin.answer', 2));
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
                'name' => 'option_id',
                'label' => trans_choice('admin.answer', 1),
                'type' => 'select',
                'entity' => 'option',
                'attribute' => 'option',
                'model' => Option::class,
            ],
            [
                'name' => 'question_id',
                'label' => trans_choice('admin.question', 2),
                'type' => 'select',
                'entity' => 'question',
                'attribute' => 'name',
                'model' => Question::class,
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AnswerRequest::class);

        $this->crud->addFields([
            [
                'name' => 'option_id',
                'label' => trans_choice('admin.answer', 1),
                'type' => 'select2_from_array',
                'options' => Answer::getOptions(),
            ],
            [
                'name' => 'question_id',
                'label' => trans_choice('admin.question', 2),
                'type' => 'select2',
                'entity' => 'question',
                'attribute' => 'name',
                'model' => Question::class,
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
