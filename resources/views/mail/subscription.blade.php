#Отклик от {{ $subscription->email }}

@component('mail::table')
|      |    Данные      |
| ------------- |:-------------:|
| {{ trans('admin.name') }}      | {{ $subscription->name }}      |
| {{ trans('admin.email') }}      | {{ $subscription->email }} |
| {{ trans('admin.phone_number') }}      | {{ $subscription->phone_number }} |
@if($subscription->course)
| {{ trans_choice('admin.course',2) }}      | {{ $subscription->course->name }} |
@endif
@endcomponent

<a href="tel::{{ $subscription->phone_number }}">Позвонить</a>
