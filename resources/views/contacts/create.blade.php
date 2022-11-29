@extends('layouts.main')
@section('title', 'Contact App | Create Contact')
@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <?php?>
                    <div class="card">
                        <div class="card-header card-title">
                            <strong>Add New Contact</strong>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="username" class="col-md-3 col-form-label">Name</label>
                                        <div class="col-md-9">
                                            <input type="text" name="username" id="username"
                                                class="form-control is-invalid">
                                            <div class="invalid-feedback">
                                                Please choose a username.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="phone" class="col-md-3 col-form-label">Phone</label>
                                        <div class="col-md-9">
                                            <input type="text" name="phone" id="phone" class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-9 offset-md-3">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <a href='{{ route('contacts.index') }}'
                                                class="btn btn-primary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php?>
                </div>
            </div>
        </div>
    </main>
@endsection
