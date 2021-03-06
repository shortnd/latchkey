@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Edit Account</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="card mb-3">
                    <div class="card-header">
                        {{ $user->name }}
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Edit basic Info</h3>
                        @if(session()->has('name'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get('name')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{route('user_update_name',$user->slug)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 text-md-right col-form-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-link" type="submit">Update</button>
                            </div>
                        </form>
                        <hr>

                        <h3 class="h6">Update Email</h3>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        @if(session()->has("email"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get("email") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{route('user_update_email', $user->slug)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="current_email" class="col-md-4 text-md-right col-form-label">Current Email</label>

                                <div class="col-md-6">
                                    <input type="current_email" name="current_email" class="form-control {{ $errors->first('current_email') ? 'is-invalid' : '' }}" placeholder="Current Email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 text-md-right col-form-label">New Email</label>

                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" placeholder="New Email" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email_confirmation" class="col-md-4 text-md-right col-form-lable">Confirm Email</label>

                                <div class="col-md-6">
                                    <input type="email" name="email_confirmation" id="email_confirmation" class="form-control" placeholder="Verify new email address">
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-link">Reset Email</button>
                            </div>
                        </form>

                        <hr>
                        <h3 class="h6">Change Password</h3>
                        @if($errors->has('password') || $errors->has('current_password'))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            {{ $error }}
                            @endforeach
                        </div>
                        @endif
                        @if(session()->has("password"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get("password") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{route('user_update_password', $user->slug)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Confirm Current Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 text-md-right col-form-label">New Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 text-md-right col-form-label">Confirm New Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm New Password">
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-link">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                @role('superuser|admin')
                @if(Auth::user()->slug != $user->slug)
                <div class="card">
                    <div class="card-header">
                        Add Role
                    </div>
                    <div class="card-body">
                        @if(session()->has("role"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session()->get("role") }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <form action="{{ route('addRoleToUser', $user) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="admin"> <input type="checkbox" name="admin" id="admin" {{$user->hasRole('admin') ? 'checked' : ''}}> Admin</label>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Add Role(s)</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @endrole
            </div>
        </div>
    </div>
@endsection
