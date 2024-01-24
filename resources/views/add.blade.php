@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
        @if (Auth::user()->role == 'kantin')
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
            <div class="col-9">
                <div class="card">
                    <div class="card-header">
                        Add Product
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label>Stock</label>
                                        <input type="number" name="stock" class="form-control">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label>Stand</label>
                                        <input type="number" name="stand" class="form-control">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-3">
                                        <label>Category</label>
                                        <select name="category_id" class="form-select">
                                            <option>-- Pilih Opsi --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
