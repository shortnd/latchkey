@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-column">
            <h2>{{ $child->fullName() }} </h2>
            <form action="{{ route('children.destroy', $child->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
            <a href="{{ route('children.edit', $child->id) }}" class="btn btn-secondary mb-3">Edit</a>
        </div>
        <div>
            <div class="card mb-3">
                <div class="card-header">
                    Current Weeks Total
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Am Hours</th>
                            <th>Total Hours</th>
                            <th>Total for Week</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $child->totals->am_total_hours }}</td>
                                <td>{{ $child->totals->total_hours }}</td>
                                <td>${{ $child->totals->total_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if($errors->has('today_checkins'))
                <div class="alert alert-danger">
                    {{ $errors->first('today_checkins') }}
                </div>
            @endif
            @if($child->todaysCheckin())
            <div class="card mb-3">
                <div class="card-header">
                    {{ today()->format('l F d, Y') }} - Current Day
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
                                    @if(!$child->todaysCheckin()->am_checkin)
                                    <form action="{{ route('am_checkin', $child->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <label for="am_checkin">Check In &nbsp;
                                            <input type="checkbox" name="am_checkin" {{ $child->todaysCheckin()->am_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $child->todaysCheckin()->am_disabled() ? 'disabled' : '' }}>
                                        </label>
                                    </form>
                                    @else
                                        Checked in at {{ $child->todaysCheckin()->amCheckinTime() }}
                                    @endif
                                </td>
                                <td>
                                    @if($child->todaysCheckin()->pm_checkin)
                                    Checked in today
                                    @else
                                    <form action="{{ route('pm_checkin', $child->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <label for="pm_checkin">Check in &nbsp;
                                            <input type="checkbox" name="pm_checkin" id="pm_checkin" {{ $child->todaysCheckin()->pm_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $child->todaysCheckin()->pm_disabled() ? 'disabled' : '' }}>
                                        </label>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if($child->todaysCheckin()->pm_checkout_time)
                                        {{ $child->todaysCheckin()->getCheckoutTime() }}
                                        <br>
                                        {{ $child->todaysCheckin()->getCheckoutDiffHumans() }}
                                    @elseif($child->todaysCheckin()->pm_checkin)
                                        <strong>Student still in latchkey</strong>
                                        <form action="{{ route('pm_checkout', $child->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <label for="pm_checkout">
                                                Checkout &nbsp;
                                                <input type="checkbox" name="pm_checkout" id="pm_checkout" {{ $child->todaysCheckin()->pm_checkout ? 'checked' : '' }} onchange="this.form.submit()">
                                            </label>
                                        </form>
                                    @else
                                        <strong>Student not in afternoon latchkey</strong>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        @foreach($child->weeklyCheckins() as $weekly)
        <div class="card mb-3">
            <div class="card-header">
                Week of {{ $weekly->first()->created_at->startOfWeek()->format('l d') }}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Day of Week</th>
                        <th>Am Checkin</th>
                        <th>Pm Checkin</th>
                        <th>Pm Checkout</th>
                    </thead>
                    <tbody>
                        @foreach($weekly as $day)
                        <tr>
                            <td>
                                {{ $day->created_at->format('D d') }}
                            </td>
                            <td>
                                {{ $day->am_checkin ? 'Was Checked In at '.$day->amCheckinTime() : 'Wasn\'t Checked in' }}
                            </td>
                            <td>
                                {{ $day->pm_checkin ? 'Was Checked in at ' . $day->pmCheckinTime() : 'Wasn\'t Checked in' }}
                            </td>
                            <td>
                                @if($day->pm_checkout_time)
                                    Checked out at {{ $day->getCheckoutTime() }}
                                @else
                                    <strong>Student was not in afternoon latchkey</strong>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
        @if($child->today->count() == 0)
            <form action="/add-day/{{ $child->id }}" method="post">
                @csrf
                <button type="submit">Add Day</button>
            </form>
        @endif
    </div>
@endsection
