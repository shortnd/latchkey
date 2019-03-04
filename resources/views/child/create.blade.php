@extends('layouts.app')

@section('content')
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div> {{$error}} </div>
                @endforeach
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Add new Child
            </div>
            <form action="{{ route('children.store') }}" method="post" id="new_child">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="{{ $errors->has('first_name') ? 'text-danger': ''}}">* First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control {{$errors->has('first_name') ? 'is-invalid': '' }}" value="{{ old('first_name') }}">
                            </div><!--/.form-group-->
                        </div><!--/.col-md-6-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="{{$errors->has('last_name') ? 'text-danger' : '' }}">* Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                            </div><!--/.form-group-->
                        </div><!--/.col-md-6-->
                    </div><!--/.row-->
                    <hr>
                    <div class="row">
                        <div class="card-header col-md-12 mb-2">
                            <h3>Optional Info</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_name" class="{{$errors->has('contact_name') ? 'text-danger' : '' }}">Contacts Name</label>
                                <input type="text" name="contact_name" id="contact_name" placeholder="Enter Contact Name" value="{{old('contact_name')}}" class="form-control {{ $errors->has('contact_name') ? 'is-invalid' : '' }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_number" class="{{ $errors->has('contact_number') ? 'text-danger' : '' }}">Contact Number</label>
                                <input type="tel" name="contact_number" id="contact_number" class="form-control {{$errors->has('contact_number') ? 'is-invalid' : '' }}" placeholder="Enter Contact Phone Number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_relationship" class="{{$errors->has('contact_relationship') ? 'text-danger': '' }}">Relationship</label>
                                <input type="text" value="{{old('contact_relationship')}}" name="contact_relationship" id="contact_relationship" placeholder="Contact's Relationship to Child" class="form-control {{$errors->has('contact_relationship') }}">
                            </div>
                        </div>
                    </div>
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

@section('scripts')
<script>
</script>
@endsection
