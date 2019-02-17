@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($checkins as $month)
            @foreach ($month as $checkin)
                {{ $checkin->created_at->format('M j') }}
            @endforeach
        @endforeach
    </div>
@endsection
