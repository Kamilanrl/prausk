@php
    function rupiah($angka){
        $hasil_rupiah = 'Rp' . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }
@endphp 

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="fs-5 fw-bold">Hai {{ Auth::user()->name }}</div>
    @if (session('status') )
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (Auth::user()->role == 'bank')
        <div class="container">
            <div class="row justify-content-center mb-3 mt-3">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-primary text-white fw-bold fs-5">
                                    Saldo
                                </div>
                                <div class="card-body">
                                    {{ rupiah($saldo) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-primary text-white fw-bold fs-5">
                                    Nasabah
                                </div>
                                <div class="card-body" style="font-size: 15px">
                                    {{ $nasabah }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-header bg-primary text-white fw-bold fs-5">
                                    Transaksi
                                </div>
                                <div class="card-body" style="font-size: 15px">
                                    {{ $transactions }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white fw-bold fs-5">
                        Request Topup
                    </div>
                    <div class="card-body">
                    @foreach($request_topup as $transaksi)
                        {{ $transaksi->credit }}
                        <form action="{{ route('acceptRequest') }}" method="POST">
                        @csrf
                            <div class="row">
                                <div class="col d-flex justify-content-start align-items-center">
                                    <input type="hidden" name="id" id="id" value="{{ $transaksi->id }}">
                                </div>
                                <div class="col d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary">SETUJU</button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (Auth::user()->role == 'siswa')
        <div class="col-md-12">
            <div class="card mb-3 mt-3">
                <div class="card-body fs-6">
                    <div class="row">
                       <div class="col d-flex justify-content-start align-items-center fs-5 fw-bold">
                           Saldo: {{ rupiah($saldo) }}
                       </div>
                       <div class="col d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary fs-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Top Up</button>
                            <form action="{{ route('topupNow') }}" method="POST">
                                @csrf
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Masukkan Nominal Top Up</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="number" class="form-control" min="10000" value="10000" name="credit">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn-btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn-btn-primary">Top Up Sekarang</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header fs-5 fw-bold bg-primary text-white">Produk</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($products as $key => $product)
                            <div class="col">
                                <form action="{{ route('addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                <input type="hidden" value="{{ $product->id }}" name="product_id">
                                <input type="hidden" value="{{ $product->price }}" name="price">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        {{ $product->name }}
                                    </div>
                                    <div class="card-body">
                                        <img width="300px" height="300px" src="{{ $product->photo }}">
                                        <div>{{ $product->description }}</div>
                                        <div>Harga: {{ rupiah($product->price) }}</div>
                                        <div>Stock: {{ $product->stock }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="mb-3">
                                            <input type="number" class="form-control" name="quantity" value="0" min="0">
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Masukkan Keranjang</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header fs-5 fw-bold bg-primary text-white">
                    Keranjang
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($carts as $key => $cart)
                            <li>{{ $cart->product->name }} | {{ $cart->quantity }} * {{ rupiah($cart->price) }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    Total Biaya: {{ rupiah($total_biaya) }}
                    <form action="{{ route('payNow') }}" method="POST">
                        <div class="d-grid gap-2 mt-2">
                            @csrf
                            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header fs-5 fw-bold bg-primary text-white">
                    Riwayat Transaksi
                </div>
                <div class="card-body">
                    @foreach ($transactions as $key => $transaction)
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row">
                                    <div class="col fw-bold">
                                        {{ $transaction[0]->order_id }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-secondary" style="font-size: 12px">
                                        {{ $transaction[0]->created_at }}
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-end align-items-center">
                                <a href="{{ route('download', ['order_id' =>$transaction[0]->order_id]) }}" class="btn btn-success" target="_blank">Download</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header fs-5 fw-bold bg-primary text-white">
                    Mutasi Wallet
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($mutasi as $data)
                        <li>
                            {{ $data->credit ? $data->credit : 'Debit' }} | {{ $data->debit ? $data->debit : 'Kredit' }} | {{ $data->description }}
                            <span class="badge text-bg-warning">
                            {{ $data->status == 'proses' ? 'PROSES' : ''}}
                            </span>
                        </li
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @if (Auth::user()->role == 'kantin')
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-header fs-5 bg-primary text-white">
                        <div class="row">
                            <div class="col d-flex align-items-center">
                                Produk
                            </div>
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#tambahProduk">
                                    Tambah
                                </button>
                                <div class="modal fade" id="tambahProduk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Produk</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row justify-content-center">
                                                        <div>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form action="{{ route('product.store') }}" method="POST" enctype="">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <div class="mb-3">
                                                                                    <label>Name</label>
                                                                                    <input type="text" name="name" class="form-control" >
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
                                                                            <div class="col-8">
                                                                                <div class="mb-3">
                                                                                    <label>Category</label>
                                                                                    <select name="category_id" class="form-select">
                                                                                        <option value="">-- Pilih Opsi --</option>
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
                                                                            <textarea name="description" class="form-control" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach ($products as $key => $product )
                                    <div class="col col-sm-12 ">
                                            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                            <input type="hidden" value="{{ $product->id }}" name="product_id">
                                            <input type="hidden" value="{{ $product->price }}" name="price">
                                            <div class="card">
                                                <div class="card-header">
                                                    {{ $product->name }}
                                                </div>
                                                <div class="card-body">
                                                    <img src="{{ $product->photo }}" style="width: 125px">
                                                    <div>{{ $product->description }}</div>
                                                    <div>Harga:  {{ rupiah($product->price) }} </div>
                                                    <div>Kategori:  {{ $product->category->name }} </div>
                                                    <div>Stock: {{ $product->stock }}</div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col">
                                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit-{{$product->id}}" >
                                                                Edit
                                                            </button>
                                                            <form action="{{ route('product.update',['id'=>$product->id]) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal fade" id="edit-{{$product->id}}" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Produk</h1>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="container">
                                                                                    <div class="row justify-content-center">
                                                                                        <div>
                                                                                            <div class="card">
                                                                                                <div class="card-body">
                                                                                                        <div class="row">
                                                                                                            <div class="col">
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Name</label>
                                                                                                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" >
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col">
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Price</label>
                                                                                                                    <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                            <div class="col-2">
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Stock</label>
                                                                                                                    <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-2">
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Stand</label>
                                                                                                                    <input type="number" name="stand" class="form-control" value="{{ $product->stand }}">
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="col-8">
                                                                                                                <div class="mb-3">
                                                                                                                    <label>Category</label>
                                                                                                                    <select name="category_id" id="" class="form-select">
                                                                                                                        <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
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
                                                                                                            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" >Submit</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col d-flex justify-content-end">
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-{{ $product->id }}">
                                                                Hapus
                                                            </button>
                                                            <div class="modal fade" id="delete-{{$product->id}}" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="deleteLabel">Delete</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('product.destroy',['id'=>$product->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <div class="modal-body text-start">Apakah anda yakin ingin menghapus {{ $product->name }} </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                            <button type="submit" class="btn btn-primary">Ya</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white fs-5">
                        Request Pick Up
                    </div>
                    <div class="card-body">
                        <div class="card">
                            @foreach ($transactions as $key => $transaction)
                                <div class="card-header fw-bold">{{ $transaction->user->name }}</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="d-flex align-items-center">
                                            <div class="col">
                                                <div class="row">
                                                    Pembelian: {{ $transaction->product->name }}
                                                </div>
                                                <div class="row">
                                                    Jumlah: {{ $transaction->quantity }}
                                                </div>
                                                <div class="row">
                                                    Stand: {{ $transaction->product->stand }}
                                                </div>
                                            </div>
                                            <div class="col text-end">
                                                <form action="{{ route('transaction.take', ['id' => $transaction->id]) }}" method="POST" >
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $transaction->id }}">
                                                <button class="btn btn-dark" type="submit" style="background-color: blue" >Accept</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
