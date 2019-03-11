@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $child->fullName() }}</h2>
        @if($child->past_due)
        <div class="alert alert-danger">
            Payment Past Due Please
        </div>
        <div class="card mb-3 text-danger">
            <div class="card-header">
                Past Due
            </div>
            <div class="card-body">
                @if($errors->has('past_due_amount'))
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                Amount Due: ${{$child->past_due}}
                <br>
                <form action="{{ route('pay-past-due', $child->slug)}}" method="post">
                    @csrf
                    @method("PATCH")

                    <div class="form-group row">
                        <label for="past_due_amount" class="col-md-4 text-right col-form-label">Payment Amount</label>

                        <div class="form-group col-md-6">
                            <input type="number" name="past_due_amount" id="past_due_amount" class="form-control" value="{{ $child->past_due }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <div class="card mb-3">
            <div class="card-header">
                Current Weeks Total Due
            </div>
            <div class="card-body">
                ${{$child->current_week_total->total_amount}}
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                Pay Total Due
            </div>
            <div class="card-body">
                @if($errors->has('total_amount'))
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
                <form action="{{ route('pay-current-week', $child->slug) }}" method="post">
                    @csrf
                    @method("PATCH")

                    <div class="form-group row">
                        <label for="total_amount" class="col-md-4 text-right col-form-label">Total Amount</label>

                        <div class="col-md-2">
                        <input type="number" name="total_amount" id="total_amount" class="form-control" value="{{ $child->current_week_total->total_amount }}"
                            {{$child->past_due ? 'disabled' : ''}}>
                        </div>
                    </div>

                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary" {{$child->past_due ? 'disabled' : ''}}>Submit Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
