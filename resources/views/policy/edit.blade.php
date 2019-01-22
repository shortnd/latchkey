@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <full-text-feild policy="{{ $page->policy }}" />
        </div>
    </div>
@endsection
