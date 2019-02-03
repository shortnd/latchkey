@extends('layouts.app')

{{-- TODO NEED TO FIX ISSUE WHERE ITS RETURNING ALL TOTALS THE SAME --}}

@push('styles')
    <style>
        .table {
            table-layout: fixed;
        }
        .pagination {
            justify-content: center;
        }
    </style>
@endpush

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">
        <h2 class="text-center">Weekly Totals</h2>
      </div>
      <div class="card-body">
        @foreach ($children as $child)
        <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col"><a href="{{ route('children.show', $child->slug) }}">{{ $child->fullName() }}</a></th>
                  <th scope="col">Week of {{ $child->checkins()->first()->created_at->format('M m') }}</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                <td colspan="1">Total Due</td>
                <td colspan="1">
                        {{ $child->weeklyTotal() > 0 ? '$'.$child->weeklyTotal() : 'Nothing Owed this week' }}
                </td>
              </tr>
          </tbody>
        </table>
        @endforeach
      </div>
    </div>
    {{ $children->links() }}
  </div>
@endsection
