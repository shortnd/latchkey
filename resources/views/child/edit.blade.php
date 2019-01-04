@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ URL::previous() }}">Back</a>
        <br>
        <form action="{{ route('children.update', $child->id) }}" method="POST">
            <div class="container">
                <div class="row">
                    @csrf
                    @method('PATCH')
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $child->first_name }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $child->last_name }}">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
