@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
        <form action="{{ route('search-results', $child->slug) }}" method="get">
            @csrf

            <div class="form-group row">
                <label for="start_date" class="col-form-label col-md-4 text-right">Start Date</label>
                <div class="col-md-6">
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ today()->subDay(1)->format('Y-m-j') }}">
                    <small>Start Date must be less then current date</small>
                </div>
            </div>

            <div class="form-group row">
                <label for="end_date" class="col-form-label col-md-4 text-right">End Date</label>
                <div class="col-md-6">
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ today()->addDay(1)->format('Y-m-j') }}">
                    <small>If searching for current day change date to one day ahead</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-4 offset-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection
