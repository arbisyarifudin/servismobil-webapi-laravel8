@extends('layouts.app')
@section('title', 'Ubah Pelanggan')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Edit Pelanggan / #{{ $customer->id }}</h2>
                        <hr>
                        @if (session('flash-success'))
                            <div class="alert alert-success">
                                {{ session('flash-success') }}
                            </div>
                        @endif
                        <form action="{{ url('customer/' . $customer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label>Nama Pelanggan</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $customer->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Email Pelanggan</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $customer->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Jenis Kelamin Pelanggan</label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="M" @if ($customer->gender == 'M') selected @endif>Laki-laki</option>
                                    <option value="F" @if ($customer->gender == 'F') selected @endif>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>No. Telp/HP Pelanggan</label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $customer->phone }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Alamat Pelanggan <code>[opsional]</code></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                                    rows="3">{{ $customer->address }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Foto Pelanggan <code>[opsional]</code></label>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ $customer->photo_url }}" alt="photo" class="img-fluid">
                                    </div>
                                    <div class="col-9">
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                            name="photo">
                                        @error('photo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label>Ganti Password <code>[opsional]</code></label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror"
                                    name="password" value="" placeholder="Masukkan password baru">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="small text-danger">
                                    Kosongkan jika tidak diubah
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('customer') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
