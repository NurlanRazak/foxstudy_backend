<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VacancyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Vacancy;
use App\Models\Company;
/**
 * Class VacancyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VacancyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel(Vacancy::class);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/vacancy');
        $this->crud->setEntityNameStrings(trans_choice('admin.vacancy', 1), trans_choice('admin.vacancy', 2));
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'company_id',
                'label' => trans_choice('admin.company', 2),
                'type' => 'select',
                'entity' => 'company',
                'attribute' => 'name',
                'model' => Company::class,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select_from_array',
                'options' => Vacancy::getStatusOptions(),
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(VacancyRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'company_id',
                'label' => trans_choice('admin.company', 2),
                'type' => 'select2',
                'entity' => 'company',
                'attribute' => 'name',
                'model' => Company::class,
            ],
            [
                'name' => 'status',
                'label' => trans('admin.status'),
                'type' => 'select2_from_array',
                'options' => Vacancy::getStatusOptions(),
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
