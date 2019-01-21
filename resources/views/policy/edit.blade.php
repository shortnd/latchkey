@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <full-text-feild content="{!! $page->content !!}"></full-text-feild>
        </div>
    </div>
@endsection
