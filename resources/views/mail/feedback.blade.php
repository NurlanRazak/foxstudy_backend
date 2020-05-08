#Отклик от {{ $feedback->email }}

@component('mail::table')
|      |    Данные      |
| ------------- |:-------------:|
| {{ trans('admin.name') }}      | {{ $feedback->name }}      |
@if($feedback->email)
| {{ trans('admin.email') }}      | {{ $feedback->email }} |
@else

@endif
| {{ trans('admin.phone_number') }}      | {{ $feedback->phone_number }} |
@if($feedback->comments)
| {{ trans('admin.comments') }}      | {{ $feedback->comments }} |
@else

@endif
@endcomponent

<a href="tel::{{ $feedback->phone_number }}">Позвонить</a>
