<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Option;
use App\Models\Question;

/**
 * Class OptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OptionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Option::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/option');
        $this->crud->setEntityNameStrings(trans_choice('admin.option', 1), trans_choice('admin.option', 2));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'option',
                'label' => trans('admin.option_title'),
            ],
            [
                'name' => 'question_id',
                'label' => trans_choice('admin.question', 2),
                'type' => 'select',
                'entity' => 'question',
                'attribute' => 'name',
                'model' => Question::class,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Option::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OptionRequest::class);

        $this->crud->addFields([
            [
                'name' => 'option',
                'label' => trans('admin.option_title'),
                'type' => 'ckeditor',
            ],
            [
                'name' => 'question_id',
                'label' => trans_choice('admin.question', 2),
                'type' => 'select2',
                'entity' => 'question',
                'attribute' => 'name',
                'model' => Question::class,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Option::getStatusOptions(),
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
