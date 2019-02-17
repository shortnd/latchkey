@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-column">
            <div class="container d-flex justify-content-between align-items-center">
                <h2 class="d-inline-block">{{ $child->fullName() }}</h2>
                <div class="d-inline-block">
                    <a class="d-block" href="{{ route('all_checkins', $child->slug) }}">All Checkins</a>
                    <a class="d-block" href="{{ route('search-form', $child->slug) }}" class="btn btn-link">Search Checkins</a>
                </div>
            </div>
            <div class="container mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ route('children.edit', $child->slug) }}" class="btn btn-secondary">Edit</a>
                <form class="form-inline" action="{{ route('children.destroy', $child->slug) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            @if($child->todaysCheckin()->late_fee)
                <div class="alert alert-danger">
                    Latefee(s) added today
                </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    Current Weeks Total
                    <br>
                    {{ today()->startOfWeek()->format('M d') }} - {{ today()->endOfWeek()->format('M d') }}
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
                                <td>{{ $child->weeklyAmCheckinTotals() }}</td>
                                <td>
                                    {{ $child->weeklyCheckinTotals() }}
                                </td>
                                <td>
                                    ${{ $child->weeklyTotal() }}
                                </td>
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
                                    <form action="{{ route('am_checkin', $child->slug) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <label for="am_checkin">Check In &nbsp;
                                            <input type="checkbox" name="am_checkin" {{ $child->todaysCheckin()->am_checkin ? 'checked' : '' }} {{ $child->todaysCheckin()->am_disabled() ? 'disabled' : '' }}>
                                        </label>
                                        @signituremodal
                                    </form>
                                    @else
                                        Checked in at {{ $child->todaysCheckin()->amCheckinTime() }}
                                    @endif
                                </td>
                                <td>
                                    @if($child->todaysCheckin()->pm_checkin)
                                    Checked in today
                                    @else
                                    <form action="{{ route('pm_checkin', $child->slug) }}" method="post">
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
                                        <form action="{{ route('pm_checkout', $child->slug) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <label for="pm_checkout">
                                                Checkout &nbsp;
                                                <input type="checkbox" name="pm_checkout" id="pm_checkout" {{ $child->todaysCheckin()->pm_checkout ? 'checked' : '' }}>
                                            </label>
                                            @signituremodal
                                        </form>
                                    @else
                                        <strong>Student not in afternoon latchkey</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr class="text-right">
                                <td colspan="3">
                                    ${{$child->todayTotal()}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <th>Am Checkin Initals</th>
                            <th>Pm Checkin Initals</th>
                        </thead>
                        <tbody>
                        @if($child->todaysCheckin()->am_sig || $child->todaysCheckin()->pm_sig)
                        <tr>
                            <td>
                                @if($child->todaysCheckin()->am_sig)
                                    <img src="{{ $child->todaysCheckin()->am_sig }}" alt="am signature" class="signature">
                                @endif
                            </td>
                            <td>
                                @if($child->todaysCheckin()->pm_sig)
                                    <img src="{{ $child->todaysCheckin()->pm_sig }}" alt="pm signature" class="signature">
                                @endif
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
        @if (count($child->weeklyCheckins()))
            <div class="card md-3">
                <div class="card-header">
                    Week of {{ startOfWeek()->format('M d') }}
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
                            @foreach($child->weeklyCheckins() as $day)
                            <tr>
                                <td>
                                    <a href="{{ route('child_checkin', [$child->slug, $day->id]) }}">{{ $day->created_at->format('D d') }}</a>
                                </td>
                                <td>
                                    {{ $day->am_checkin ? 'Was Checked In at '. $day->amCheckinTime() : 'Wasn\'t Checked in' }}
                                </td>
                                <td>
                                    {{ $day->pm_checkin ? 'Was Checked in at '.$day->pmCheckinTime() : 'Wasn\'t Checked in' }}
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
        @endif
        @if($child->today->count() == 0)
            <form action="/add-day/{{ $child->slug }}" method="post">
                @csrf
                <button type="submit">Add Day</button>
            </form>
        @endif
    </div>
@endsection
