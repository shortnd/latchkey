@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Harper Woods School Latchkey Policy</h2>
            </div><!--/.card-header-->
            <div class="card-body">
                {!! $policy->policy !!}
            </div><!--/.card-body-->
        </div><!--/.card-->
    </div>
@endsection
