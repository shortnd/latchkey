@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        Request an Invitation
                    </div>
                    <div class="card-body">
                        {{ config('app.name') }} is closed to open registration. You must be invited in, you can request your link below.

                        <form action="{{ route('storeInvitation') }}" method="POST" class="form mt-3">
                            {{ csrf_field() }}

                            <div class="form-group row {{$errors->has('email') ? 'has-error' : ''}}">
                                <label
                                    for="email"
                                    class="col-md-4 col-form-label text-md-right">
                                    E-Main Address
                                </label>

                                <div class="col-md-6">
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    placeholder="Enter your email address"
                                    aria-placeholder="Enter your email address"
                                    required
                                    autofocus />

                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                    type="submit"
                                    class="btn btn-primary"
                                    aria-placeholder="Request An Invite">
                                        Request
                                    </button>

                                    <a href="{{ route('login') }}" class="btn btn-link">
                                        Already Have An Account?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
