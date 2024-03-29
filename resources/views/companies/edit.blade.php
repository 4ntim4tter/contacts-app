@extends('layouts.main')
@section('title', 'Contact App | Edit Company')
@section('content')
<main class="py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-8">
                <?php?>
                <div class="card">
                    <div class="card-header card-title">
                        <strong>Add New Company</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('companies.update', $company->id) }}" method="POST">
                            @csrf
                            @method('put')
                            @include('companies._form')
                        </form>
                    </div>
                </div>
                <?php?>
            </div>
        </div>
    </div>
</main>
@endsection
