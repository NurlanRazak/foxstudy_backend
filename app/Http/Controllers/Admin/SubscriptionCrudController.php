<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubscriptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Course;
use App\User;
use App\Models\Subscription;

/**
 * Class SubscriptionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubscriptionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Subscription');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subscription');
        $this->crud->setEntityNameStrings(trans_choice('admin.subscription', 1), trans_choice('admin.subscription', 2));
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
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'payment_status',
                'label' => trans('admin.payment_status'),
                'type' => 'select_from_array',
                'options' => Subscription::getPaymentStatusOptions(),
            ],
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
            ],
            [
                'name' => 'course_id',
                'label' => trans_choice('admin.course',2),
                'type' => 'select',
                'entity' => 'course',
                'attribute' => 'name',
                'model' => Course::class,
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
                'name' => 'email',
                'label' => 'Email',
            ],
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(SubscriptionRequest::class);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('admin.name'),
            ],
            [
                'name' => 'phone_number',
                'label' => trans('admin.phone_number'),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'course_id',
                'label' => trans_choice('admin.course',2),
                'type' => 'select',
                'entity' => 'course',
                'attribute' => 'name',
                'model' => Course::class,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'user_id',
                'label' => trans('admin.user'),
                'type' => 'select',
                'entity' => 'user',
                'attribute' => 'email',
                'model' => User::class,
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'email',
                'label' => 'Email',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [
                'name' => 'payment_status',
                'label' => trans('admin.payment_status'),
                'type' => 'select2_from_array',
                'options' => Subscription::getPaymentStatusOptions(),
                'wrapperAttributes' => [
                    'class' => 'form-group col-sm-12',
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
