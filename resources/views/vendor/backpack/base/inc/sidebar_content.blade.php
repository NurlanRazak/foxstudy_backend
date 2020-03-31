<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('category') }}'><i class='nav-icon fa fa-list'></i> {{ trans_choice('admin.category', 2) }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('subcategory') }}'><i class='nav-icon fa fa-list-alt'></i> {{ trans_choice('admin.subcategory', 2) }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('course') }}'><i class='nav-icon fa fa-desktop'></i> {{ trans_choice('admin.course', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('student') }}'><i class='nav-icon fa fa-graduation-cap'></i> {{ trans_choice('admin.student', 2) }}</a></li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('company') }}'><i class='nav-icon fa fa-university'></i> {{ trans_choice('admin.company', 2) }}</a></li>
