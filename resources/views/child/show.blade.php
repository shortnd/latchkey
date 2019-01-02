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
            @if($errors->has('today_checkins'))
                {{ $errors->first('today_checkins') }}
            @endif
            @foreach($child->checkins()->get() as $day)
            <div>
                {{ $day->created_at->format('F  d, Y') }} {{ $day->am_checkin }} {{ $day->pm_checkin }} {{ $day->pm_checkout }}
            </div>
            @endforeach
        </div>
            @if($child->today->count() == 0)
                <form action="/add-day/{{ $child->id }}" method="post">
                    @csrf
                    <button type="submit">Add Day</button>
                </form>
            @endif
    </div>
@endsection
