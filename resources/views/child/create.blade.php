@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <form action="{{ route('children.store') }}" method="post">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
                            </div><!--/.form-group-->
                        </div><!--/.col-md-6-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control">
                            </div><!--/.form-group-->
                        </div><!--/.col-md-6-->
                    </div><!--/.row-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Kid</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div><!--/.form-group-->
                        </div>
                    </div>
                </div><!--/.container-->
            </form>
        </div><!--./card-->
    </div><!--/.container-->
@endsection
