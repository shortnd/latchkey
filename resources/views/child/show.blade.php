@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-column">
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
                <div class="alert alert-danger">
                    {{ $errors->first('today_checkins') }}
                </div>
            @endif
            @if($child->todaysCheckin())
            <div class="card mb-3">
                <div class="card-header">
                    {{ \Carbon\Carbon::today()->format('F d Y') }} - Current Day
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th scope="col">Am Checkin</th>
                            <th scope="col">PM Checkin</th>
                            <th scope="col">PM Checkout</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ $child->todaysCheckin()->am_checkin }}
                                </td>
                                <td>
                                    {{ $child->todaysCheckin()->pm_checkin }}
                                </td>
                                <td>
                                    @if($child->todaysCheckin()->pm_checkout)
                                        {{ $child->todaysCheckin()->pm_checkout }}
                                    @else
                                        <strong>Not Checked in for PM</strong>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    Past Week
                </div>
                <table class="table">
                    <thead>
                        <th scope="col">Day of Week</th>
                        <th scope="col">Am Checkin</th>
                    </thead>
                    <tbody>
                        @foreach($child->pastWeeksCheckin() as $day)
                            <tr>
                                <td>
                                    {{ $day->created_at->format('D d') }}
                                </td>
                                <td>
                                    {{ $day->am_checkin ? 'Was Checked In' : 'Wasn\'t Checked in' }}
                                </td>
                                <td>
                                    {{ $day->pm_checkin ? 'Was Checked in at' . $day->pm_checkin_time : 'Wasn\'t Checked in' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {!! $child->pastWeeksCheckin() !!}
                </table>
            </div>
        </div>
        @if($child->today->count() == 0)
            <form action="/add-day/{{ $child->id }}" method="post">
                @csrf
                <button type="submit">Add Day</button>
            </form>
        @endif
    </div>
@endsection
