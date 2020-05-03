#Отклик от {{ $feedback->email }}

@component('mail::table')
|      |    Данные      |
| ------------- |:-------------:|
| {{ trans('admin.name') }}      | {{ $feedback->name }}      |
| {{ trans('admin.email') }}      | {{ $feedback->email }} |
| {{ trans('admin.phone_number') }}      | {{ $feedback->phone_number }} |
| {{ trans('admin.comments') }}      | {{ $feedback->comments }} |
@endcomponent

<a href="tel::{{ $feedback->phone_number }}">Позвонить</a>
