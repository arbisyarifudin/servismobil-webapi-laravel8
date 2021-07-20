@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Tambah Produk</h2>
                        <hr>
                        <form action="{{ url('product') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Nama Produk</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Harga Produk</label>
                                <input type="number" class="form-control  @error('price') is-invalid @enderror" name="price"
                                    value="{{ old('price') }}" required>
                                    @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi Produk</label>
                                <textarea class="form-control @error('about') is-invalid @enderror" name="about" rows="3"
                                    required>{{ old('about') }}</textarea>
                                @error('about')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Gambar Produk <code>[opsional]</code></label>
                                <input type="file" class="form-control @error('picture') is-invalid @enderror"
                                    name="picture">
                                @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Kategori Produk</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id"
                                    required>
                                    <option value="">--Pilih--</option>
                                    @foreach ($categories as $category)
                                        <option @if (old('category_id') == $category->id) selected @endif value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Status Produk</label>
                                <select class="form-control @error('is_active') is-invalid @enderror" name="is_active"
                                    required>
                                    <option value="">--Pilih--</option>
                                    <option @if (old('is_active') == "1") selected @endif value="1">Aktif</option>
                                    <option @if (old('is_active') == "0") selected @endif value="0">Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('product') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
