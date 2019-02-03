@extends('layouts.app')

@section('content')
<div class="card container p-3">
    <div class="card-header">
        <h2>
            <a href="{{ route('children.show', $child->slug) }}">
                {{ $child->fullName() }}
            </a>
        </h2>
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
                <tr>
                    <td>{{ $checkin->created_at->format('M d') }}</td>
                    <td>{{ $checkin->am_checkin ? 'Checked in at '. $checkin->am_checkin_time : 'Wasn\'t Checked in' }}</td>
                    <td>{{ $checkin->pm_checkin ? 'Checked in at '. $checkin->pm_checkin_time : 'Wasn\'t Checked in' }}</td>
                    <td>
                        @if($child->todaysCheckin()->pm_checkout_time)
                            {{ $child->todaysCheckin()->getCheckoutTime() }}
                            <br>
                            {{ $child->todaysCheckin()->getCheckoutDiffHumans() }}
                        @else
                            <strong>Student not in afternoon latchkey</strong>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table">
            <thead>
                <th>Am Signature</th>
                <th>Pm Signature</th>
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
@endsection
