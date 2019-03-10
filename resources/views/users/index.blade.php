@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="aside-background"></div><!--/.aside-background-->
            <aside class="col-md-3">
                <h2>Users</h2>
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{route('showRequests')}}">View Requests</a></l>
                </ul>
            </aside>
            <section class="col-md-9">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            All Users
                        </div>
                        <div class="card-body">
                            @if(count($users))
                            <table class="table">
                                <thead>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                <a href="{{ route('user.edit', $user->slug) }}">{{$user->name}}</a>
                                            </td>
                                            <td>
                                                {{$user->email}}
                                            </td>
                                            <td>
                                                @if(count($user->roles))
                                                    @foreach ($user->getRoleNames() as $role)
                                                        {{$role}}
                                                    @endforeach
                                                @else
                                                    No Roles
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <p class="text-center">No Users Registered</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
