@extends('layouts.app')
@section('title', 'Tambah Paket')
@section('content')

    <div class="container" id="app">
        <form action="{{ url('package') }}" method="POST">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h2>Tambah Paket</h2>
                        <hr>
                            @csrf
                            <div class="mb-3">
                                <label>Nama Paket</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi Paket</label>
                                <textarea class="form-control @error('about') is-invalid @enderror" name="about" rows="3"
                                    required>{{ old('about') }}</textarea>
                                @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <div>
                                <h4>Produk Paket</h4>
                                @error('product_id')
                                    <div class="text-danger small">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <product-package-list/>
                            </div>          
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('package') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <product-list/>
                </div>
            </div>
        </form>
    </div>
@endsection
