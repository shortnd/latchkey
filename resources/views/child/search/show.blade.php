@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($checkins as $month)
            <div class="card">
                <div class="card-header">
                    {{ $month->first()->created_at->format('M') }}
                </div>
                <div class="card-body">
                    @foreach ($month as $checkin)
                    <table class="table">
                        <thead>
                            <th>Day</th>
                            <th>Am Checkin</th>
                            <th>PM Checkin</th>
                            <th>PM Checkout</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {{ $checkin->created_at->format('M j') }}
                                </td>
                                <td>
                                    {{ $checkin->am_checkin }}
                                </td>
                                <td>
                                    {{ $checkin->pm_checkin }}
                                </td>
                                <td>
                                    {{ $checkin->pm_checkout ? 'Not checkin in for PM Latchkey' : $checkin->pm_checkout_time }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
