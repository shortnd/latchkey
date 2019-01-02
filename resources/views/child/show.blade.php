@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <small>{{ $child->id }}</small>
            <h2>{{ $child->first_name }}</h2>
            <form action="{{ route('children.destroy', $child->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
        <div>
            @foreach($child->checkins()->get() as $day)
                {{ $day->am_checkin }} {{ $day->pm_checkin }} {{ $day->pm_checkout }}
            @endforeach
        </div>
        @if($child->checkins()->first()->today())
            <form action="/add-day/{{ $child->id }}" method="post">
                @csrf
                <button type="submit">Add Day</button>
            </form>
        @endif
    </div>
@endsection
