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
                    <tr>
                        @foreach($children as $child)
                           <td>
                               <a  href="{{ route('children.show', $child->id) }}">{{ $child->first_name }} {{ $child->last_name }}</a>
                            </td>
                            @foreach($child->checkins()->get() as $day)
                                <td>
                                    {{ $day }}
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
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
