@component('mail::message')
# {{ $child->fullname() }}

Your total for the week of {{ startOfWeek()->format('M d') }} is {{ $child->checkin_totals->total_amount }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent