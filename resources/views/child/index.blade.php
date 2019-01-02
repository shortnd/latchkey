@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <a href="{{ route('children.create') }}" class="btn btn-primary">Add Child</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
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
                                    <input type="checkbox" name="" id="" {{ $day->am_checkin ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input type="checkbox" name="" id="" {{ $day->pm_checkin ? 'checked' : '' }}>
                                </td>
                                <td>
                                    @if($day->pm_checkout_time)
                                        {{ $day->pm_checkout_time }}
                                    @elseif($day->pm_checkin)
                                        <strong>Student still in latchkey</strong>
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
        </div>
    </div>
@endsection
