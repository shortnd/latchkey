@extends('layouts.app')

@section('content')
    <div class="container">
        <header>
            <nav>
                <a href="{{ URL::previous() }}">Back</a>
            </nav>
        </header>
        <br>
        <div class="card mb-3">
            <div class="card-header">
                Basic Info
            </div>
            <div class="card-body">
                <form action="{{ route('children.update', $child->slug) }}" method="POST">
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
        </div>
        <div class="card">
            <div class="card-header">
                Contact Info
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="contact_name">Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{$child->contact_name}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="tel" name="contact_number" id="contact_number" value="{{ $child->contact_number }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="contact_relationship">Relationship</label>
                        <input type="text" name="contact_relationship" id="contact_relationship" class="form-control" value="{{$child->contact_relationship}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
