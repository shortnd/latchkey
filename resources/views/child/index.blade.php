@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <a href="{{ route('children.create') }}" class="btn btn-primary">Add Child</a>
            </div>
        </div>
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
                        @if($children->count() > 0)
                        @foreach($children as $child)
                            <tr>
                               <td>
                                   <a  href="{{ route('children.show', $child->id) }}">{{ $child->first_name }} {{ $child->last_name }}</a>
                                </td>
                                @foreach($child->today_checkin as $day)
                                    <td>
                                        @if(!$day->am_checkin)
                                        <form action="{{ route('am_checkin', $child->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <label for="am_checkin">Check In &nbsp;
                                                <input type="checkbox" name="am_checkin" {{ $day->am_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $day->disabled() ? 'disabled' : '' }}>
                                            </label>
                                        </form>
                                        @else
                                            Checked in at {{ $day->amCheckinTime() }}
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('pm_checkin', $child->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <label for="pm_checkin">Check in &nbsp;
                                                <input type="checkbox" name="pm_checkin" id="pm_checkin" {{ $day->pm_checkin ? 'checked' : '' }} onchange="this.form.submit()" {{ $day->disabled() ? 'disabled' : '' }}>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        @if($day->pm_checkout_time)
                                            {{ $day->pm_checkout_time }}
                                        @elseif($day->pm_checkin)
                                            <strong>Student still in latchkey</strong>
                                            <form action="{{ route('pm_checkout', $child->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <label for="pm_checkout">
                                                    Checkout &nbsp;
                                                    <input type="checkbox" name="pm_checkout" id="pm_checkout" {{ $day->pm_checkout ? 'checked' : '' }} onchange="this.form.submit()">
                                                </label>
                                            </form>
                                        @else
                                            <strong>Student not in afternoon latchkey</strong>
                                        @endif
                                    </td>
                                @endforeach
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
    </div>
@endsection
