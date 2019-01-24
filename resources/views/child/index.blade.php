@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <a href="{{ route('children.create') }}" class="btn btn-primary">Add Child</a>
            </div>
        </div>
        @if ($children->count())
        <div class="row">
            <div class="card w-100">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                Full Name
                            </th>
                            <th>
                                Am Checked in?
                            </th>
                            <th>
                                Pm Check in?
                            </th>
                            <th>
                                Pm Check out?
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($children)
                            @foreach($children as $child)
                        <child-table-row route="{{ route('children.show', $child->id) }}" child="{{ $child }}"></child-table-row>
                            <tr>
                                <td>
                                    <a href="{{ route('children.show', $child->id) }}">{{ $child->first_name }} {{ $child->last_name }}</a>
                                </td>
                                <td>
                                    @if(!$child->today_checkin->am_checkin)
                                    <form action="{{ route('am_checkin', $child->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <label for="am_checkin">Check In &nbsp;
                                            <input type="checkbox" name="am_checkin" {{ $child->today_checkin->am_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $child->today_checkin->am_disabled() ? 'disabled' : '' }}>
                                        </label>
                                    </form>
                                    @else
                                        Checked in at {{ $child->today_checkin->amCheckinTime() }}
                                    @endif
                                </td>
                                <td>
                                    @if($child->today_checkin->pm_checkin)
                                    Checked in today
                                    @else
                                    <form action="{{ route('pm_checkin', $child->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <label for="pm_checkin">Check in &nbsp;
                                            <input type="checkbox" name="pm_checkin" id="pm_checkin" {{ $child->today_checkin->pm_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $child->today_checkin->pm_disabled() ? 'disabled' : '' }}>
                                        </label>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if($child->today_checkin->pm_checkout_time)
                                        {{ $child->today_checkin->getCheckoutTime() }}
                                        <br>
                                        {{ $child->today_checkin->getCheckoutDiffHumans() }}
                                    @elseif($child->today_checkin->pm_checkin)
                                        <strong>Student still in latchkey</strong>
                                        <form action="{{ route('pm_checkout', $child->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <label for="pm_checkout">
                                                Checkout &nbsp;
                                                <input type="checkbox" name="pm_checkout" id="pm_checkout" {{ $child->today_checkin->pm_checkout ? 'checked' : '' }} onchange="this.form.submit()">
                                            </label>
                                        </form>
                                    @else
                                        <strong>Student not in afternoon latchkey</strong>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td>No Children</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div><!--/.card-->
        </div>
        @else
        <h2 class="text-center">No Children</h2>
        @endif
    </div>
@endsection
