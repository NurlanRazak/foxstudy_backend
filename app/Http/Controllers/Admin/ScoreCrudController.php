<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ScoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Staff;
use App\Models\Vacancy;

/**
 * Class ScoreCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ScoreCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Score');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/score');
        $this->crud->setEntityNameStrings(trans_choice('admin.score', 1), trans_choice('admin.score',2));
        $this->crud->denyAccess(['create']);
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'staff_id',
                'label' => trans('admin.name'),
                'type' => 'select',
                'entity' => 'staff',
                'attribute' => 'name',
                'model' => Staff::class,
            ],
            [
                'name' => 'vacancy_id',
                'label' => trans('admin.vacancy_name'),
                'type' => 'select',
                'entity' => 'vacancy',
                'attribute' => 'name',
                'model' => Vacancy::class,
            ],
            [
                'name' => 'score',
                'label' => trans('admin.res_score'),
                'suffix' => ' %',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ScoreRequest::class);

        $this->crud->addFields([
            [
                'name' => 'staff_id',
                'label' => trans('admin.name'),
                'type' => 'select2',
                'entity' => 'staff',
                'attribute' => 'name',
                'model' => Staff::class,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'vacancy_id',
                'label' => trans('admin.vacancy_name'),
                'type' => 'select2',
                'entity' => 'vacancy',
                'attribute' => 'name',
                'model' => Vacancy::class,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6',
                ],
            ],
            [
                'name' => 'score',
                'label' => trans('admin.res_score'),
                'suffix' => ' %',
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
