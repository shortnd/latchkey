@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($checkins as $week)
        <div class="card mb-3">
            <div class="card-header">
               Week of {{$week->first()->created_at->format('M j')}}
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>Day</th>
                        <th>Am Checkin</th>
                        <th>Pm Checkin</th>
                        <th>Pm Checkout</th>
                    </thead>
                    <tbody>
                        @foreach($week as $day)
                            <tr>
                                <td>
                                    {{ $day->created_at->format('M j') }}
                                </td>
                                <td>
                                    {{ $day->am_checkin ? 'Was Checked in at '. $day->amCheckinTime() : 'Wasn\'t Checked in' }}
                                </td>
                                <td>
                                    {{ $day->pm_checkin ? 'Was Checked in at '. $day->pmCheckinTime() : 'Wasn\'t Checked in' }}
                                </td>
                                <td>
                                    {{ $day->pm_checkout ? 'Checked out at '. $day->getCheckoutTime() : 'Student was not in afternoon latchkey' }}
                                </td>
                            </tr>
                            @if($day->am_sig || $day->pm_sig)
                            <tr class="container">
                                <td colspan="2" class="text-center">
                                    <strong class="d-block">Am Signature</strong>
                                    <img src="{{ $day->am_sig }}" alt="am signature" class="signature" />
                                </td>
                                <td colspan="2" class="text-center">
                                    <strong class="d-block">Pm Signature</strong>
                                    <img src="{{ $day->pm_sig }}" alt="pm signature" class="signature">
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
@endsection
