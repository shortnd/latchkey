@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center">Edit Account</h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        {{ $user->name }}
                    </div>
                    <div class="card-body">
                        <h3 class="h6">Edit basic Info</h3>
                        <form action="{{route('user_update_name',$user->slug)}}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group row">
                                <label for="name" class="col-md-4 text-md-right col-form-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 text-md-right col-form-label">Username:</label>
                                <div class="col-md-6">
                                    <input type="text" name="username" id="username" value="{{$user->username}}" class="form-control" disabled>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-link" type="submit">Update</button>
                            </div>
                        </form>
                        <hr>

                        <h3 class="h6">Update Email</h3>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
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
                        <form action="" method="post">
                            @csrf

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Confirm Current Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password" class="col-md-4 text-md-right col-form-label">New Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password_confirmed" class="col-md-4 text-md-right col-form-label">Confirm New Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="new_password_confirmed" id="new_password_confirmed" class="form-control" placeholder="Confirm New Password">
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-link">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
