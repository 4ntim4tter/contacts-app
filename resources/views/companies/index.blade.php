@extends('layouts.main')
@section('title', 'Contact App | All companies')
@section('content')
<main class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-title">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">
                                All Companies
                                @if (request()->query('trash'))
                                (in Trash)
                                @endif
                            </h2>
                            <div class="ml-auto">
                                <a href="{{ route('companies.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i>Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @includewhen(!empty($companies), 'companies._filter')
                        @if ($message = session('message'))
                        <div class="alert alert-success">{{ $message }}
                            @if ($undoRoute=session('undoRoute'))
                            <form action="{{ $undoRoute }}" method="POST" style="display: inline">
                                @csrf
                                @method('delete')
                                <button class="btn alert-link">Undo</button>
                            </form>
                            @endif
                        </div>

                        @endif
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        {!! sortable("Name") !!}
                                    </th>
                                    <th>
                                        {!! sortable("Address") !!}
                                    </th>
                                    <th>
                                        {!! sortable("Email") !!}
                                    </th>
                                    <th>Contacts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $showTrashButtons = request()->query('trash') ? true : false;
                                @endphp
                                @forelse ($companies as $index => $company)
                                @include('companies._contact', ['company' => $company, 'index' => $index])
                                @empty
                                @include('companies._empty')
                                @endforelse
                                {{-- @each('companies._contact', $companies, 'contact', 'companies._empty') --}}
                            </tbody>
                        </table>
                        {{ $companies->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
