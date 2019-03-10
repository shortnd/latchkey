@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row flex-column">
            <div class="container d-flex justify-content-between align-items-center">
                <h2 class="d-inline-block">{{ $child->fullName() }}</h2>
                <div class="d-inlin-block">
                    <a href="{{ route('all_checkins', $child->slug) }}" class="d-block">All Checkins</a>
                    <a href="{{ route("search-form", $child->slug) }}" class="d-block">Search Checkins</a>
                </div>
            </div>
            @role('superuser|admin')
            <div class="container mb-3 d-flex justify-content-between align-items-center">
                <a href="{{ route("children.edit", $child->slug) }}" class="btn btn-secondary">Edit</a>
                <form class="form-inline" action="{{ route("children.destroy", $child->slug) }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
            @endrole
            @if($child->today_checkin->late_fee)
                <div class="alert alert-danger">
                    Latefee(s) added today {{ $child->today_checkins->late_fee }}
                </div>
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    Basic Contact Info
                </div>
                <div class="card-body">
                    <h2>{{ $child->contact_name }} - {{ $child->contact_relationship }}</h2>
                    <h3 class="h6">Tel {{ $child->contact_number }}</h3>
                </div>
            </div><!--/.card.mb-3-->
            @if($child->past_due)
            <div class="card mb-3 alert-danger">
                <div class="card-header">
                    Amount Past Due
                </div>
                <div class="card-body">
                    <strong>Amount past due ${{$child->past_due}}</strong>
                </div>
            </div><!--/.card.mb-3.alert-danger-->
            @endif
            <div class="card mb-3">
                <div class="card-header">
                    Current Weeks Total
                    <br>
                    {{ startOfWeek()->format('M d') }} - {{ endOfWeek()->format('M d') }}
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
                                <td>{{ $child->week_totals->am_total_hours }}</td>
                                <td>{{ $child->week_totals->total_hours }}</td>
                                <td>${{ $child->week_totals->total_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!--/.card.mb-3-->
            @if($errors->has('today_checkins'))
                <div class="alert alert-danger">
                    {{ $errors->first('todays_checkin') }}
                </div>
            @endif
            @if ($child->today_checkin)
            <div class="card mb-3">
                <div class="card-header">
                    {{ today()->format('l F d, Y') }} - Current Day
                </div>
                <div class="card-body container">
                    <table class="table">
                        <thead>
                            <th>Am Checkin</th>
                            <th>PM Checkin</th>
                            <th>PM Checkout</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if (!$child->today_checkin->am_checkin)
                                    <form action="{{ route('am_checkin', $child->slug) }}">
                                        @csrf
                                        @method('PATCH')
                                        <label for="am_checkin">Check In &nbsp; <input type="checkbox" name="am_checkin" id="am_checkin" {{ $child->today_checkin->am_checkin ? 'checked': '' }} {{ $child->today_checkin->am_disabled() ? 'disabled': '' }}></label>
                                        @signituremodal
                                    </form>
                                    @else
                                        Checked in at {{ $child->amCheckinTime() }}
                                    @endif
                                </td>
                                <td>
                                    @if(!$child->today_checkin->pm_checkin)
                                    <form action="{{ route("pm_checkin", $child->slug) }}" method="POST">
                                        @csrf
                                        @method("PATCH")
                                        <label for="pm_checkin">Check in &nbsp;
                                            <input type="checkbox" name="pm_checkin" id="pm_checkin" {{$child->today_checkin->pm_checkin ? 'checked': ''}}
                                            onchange="this.form.submit()" {{ $child->today_checkin->pm_disabled() ? 'disabled': '' }}>
                                        </label>
                                    </form>
                                    @else
                                        Checked in today
                                    @endif
                                </td>
                                <td>
                                    @if(!$child->today_checkin->pm_checkout_time)
                                    <strong>Student still in latchkey</strong>
                                    <form action="{{ route("pm_checkout", $child->slug) }}" method="POST">
                                        @csrf
                                        @method("PATCH")
                                        <label for="pm_checkout">Checkout &nbsp; <input type="checkbox" name="pm_checkout" id="pm_checkout" {{ $child->today_checkin->pm_checkout ? 'checked' : ''}}></label>
                                        @signituremodal
                                    </form>
                                    @elseif($child->today_checkin->pm_checkout_time)
                                        {{ $child->today_checkin->getCheckoutTime() }}
                                        <br>
                                        {{ $child->today_checkin->getCheckoutDiffHumans() }}
                                    @else
                                        <strong>Student not in afternoon latchkey</strong>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Todays Total</strong>
                                </td>
                                <td colspan="2" class="text-right">
                                    ${{ $child->today_total($child->today_checkin) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                            <th>Am Checkin Initals</th>
                            <th>PM Checkout Initials</th>
                        </thead>
                        <tbody>
                            @if($child->today_checkin->am_sig || $child->todays_checkin_pm_sig)
                                <td>
                                    @if($child->today_checkin->am_sig)
                                    <img src="{{ $child->today_checkin->am_sig }}" alt="am signature" class="signature">
                                    @endif
                                </td>
                                <td>
                                    @if($child->today_checkin->pm_sig)
                                    <img src="{{ $child->today_checkin->pm_sig }}" alt="pm signature" class="signature">
                                    @endif
                                </td>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div><!--/.card.mb-3-->
            @endif
            @if($child->checkins)
            <div class="card mb-3">
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
                            @foreach($child->checkins as $day)
                            <tr>
                                <td>
                                    <a href="{{ route("child_checkin", [$child->slug, $day->id]) }}">{{ $day->created_at->format('D d') }}</a>
                                </td>
                                <td>
                                    {{ $day->am_checkin ? "Was Checked in at {$day->amCheckinTime()}" : "Wasn't Checked in" }}
                                </td>
                                <td>
                                    {{ $day->pm_checkin ? "Was Checked in at {$day->pmCheckinTime()}" : "Was't Checked in" }}
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
            </div><!--/.card.mb-3-->
            @endif
        </div>
    </div>
@endsection
