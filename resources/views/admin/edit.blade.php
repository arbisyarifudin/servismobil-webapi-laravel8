@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Ubah Karyawan</h2>
                        <hr>
                        <form action="{{ url('admin/' . $admin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label>Nama Karyawan</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $admin->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>NIK Karyawan <code>[opsional]</code></label>
                                <input type="text" class="form-control  @error('nin') is-invalid @enderror" name="nin"
                                    value="{{ $admin->nin }}" >
                                    @error('nin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>No. Telp/HP Karyawan <code>[opsional]</code></label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $admin->phone }}" >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Alamat Karyawan <code>[opsional]</code></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                    >{{ $admin->address }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Foto Karyawan <code>[opsional]</code></label>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ $admin->photo_url }}" alt="photo" class="img-fluid">
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
                            <div class="mb-3">
                                <label>Status Karyawan</label>
                                <select class="form-control @error('is_active') is-invalid @enderror" name="is_active"
                                    required>
                                    <option @if ($admin->is_active == "1") selected @endif value="1">Aktif</option>
                                    <option @if ($admin->is_active == "0") selected @endif value="0">Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                @if (auth()->user()->level=='Admin')
                                <label>Level Karyawan</label>
                                <select class="form-control @error('level') is-invalid @enderror" name="level"
                                    required>                                    
                                    <option @if ($admin->level == "Admin") selected @endif value="Admin">Admin</option>
                                    <option @if ($admin->level == "Manager") selected @endif value="Manager">Manajer</option>
                                    <option @if ($admin->level == "Staff") selected @endif value="Staff">Karyawan</option>
                                </select>
                                @error('level')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                                @else
                                <input type="hidden" name="level" class="form-control" value="Staff">
                                @endif
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label>Ganti Password <code>[opsional]</code></label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                                    value="" placeholder="Masukkan password baru">
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
                            <a href="{{ url('admin') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
