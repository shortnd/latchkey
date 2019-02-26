@extends('layouts.app')

@section('content')
    <div class="contaienr">
        <div class="page-header text-center">
            <h2>Invitation Requested</h2>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-3">
                    <div class="card-header">
                        Pending Requests <span class="badge">{{ count($invitations) }}</span>
                    </div>
                    <div class="card-body">
                        @if(!empty($invitations))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Invitation Link</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invitations as $invitation)
                                            <tr>
                                                <td>
                                                    <a href="mailto:{{ $invitation->email }}">
                                                        {{ $invitation->email }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $invitation->created_at }}
                                                </td>
                                                <td>
                                                    <kbd>{{ $invitation->getLink() }}</kbd>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No invitations pending.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
