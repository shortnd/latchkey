@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center">Weekly Totals</h2>
      </div>
      <div class="card-body">
        @foreach ($children as $child)
        <table class="table">
          <thead>
            {{ $child->fullName() }}
          </thead>
          <tbody>
            <tr>
            </tr>
          </tbody>
        </table>
            {{-- {{ $child }} --}}
        @endforeach
      </div>
    </div>
    {{ $children->links() }}
  </div>
@endsection