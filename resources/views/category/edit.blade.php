@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Ubah Produk</h2>
                        <hr>
                        @if (session('flash-success'))
                            <div class="alert alert-success">
                                {{ session('flash-success') }}
                            </div>
                            @endif
                            <form action="{{ url('category/' . $category->id) }}" method="POST">
                            @csrf
                            @method('put')
                                <div class="mb-3">
                                    <label>Nama Kategori</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $category->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label>Deskripsi Kategori</label>
                                    <textarea class="form-control @error('about') is-invalid @enderror" name="about" rows="3"
                                        required>{{ $category->about }}</textarea>
                                    @error('about')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('category') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
