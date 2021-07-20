@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Tambah Pegawai</h2>
                        <hr>
                        <form action="{{ url('admin') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Nama Pegawai</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Username Pegawai</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Password Pegawai</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>NIK Pegawai <code>[opsional]</code></label>
                                <input type="text" class="form-control  @error('nin') is-invalid @enderror" name="nin"
                                    value="{{ old('nin') }}" >
                                    @error('nin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>No. Telp/HP Pegawai <code>[opsional]</code></label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Alamat Pegawai <code>[opsional]</code></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                    >{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Foto Pegawai <code>[opsional]</code></label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                    name="photo">
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                @if (auth()->user()->level == 'Admin')  
                                <label>Level Pegawai</label>
                                <select class="form-control @error('level') is-invalid @enderror" name="level"
                                    required>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manajer</option>
                                        <option value="Staff">Karyawan</option>
                                    </select>
                                    @error('level')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                @else
                                <input type="hidden" name="level" value="Staff">
                                @endif
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('admin') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
