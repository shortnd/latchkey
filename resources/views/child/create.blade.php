@extends('layouts.app')

@section('content')
    <div class="container">
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
                    <hr>
                    <div class="row">
                        <div class="card-header col-md-12 mb-2">
                            <h3>Optional Info</h3>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_name">Contacts Name</label>
                                <input type="text" name="contact_name" id="contact_name" placeholder="Enter Contact Name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_number">Contact Number</label>
                                <input type="tel" name="contact_number" id="contact_number" class="form-control" placeholder="Enter Contact Phone Number">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact_relationship">Relationship</label>
                                <input type="text" name="contact_relationship" id="contact_relationship" placeholder="Contact's Relationship to Child" class="form-control">
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
