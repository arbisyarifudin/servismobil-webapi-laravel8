@extends('layouts.app')
@section('title', 'Ubah Montir')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Ubah Montir</h2>
                        <hr>
                        @if (session('flash-success'))
                        <div class="alert alert-success">
                            {{ session('flash-success') }}
                        </div>
                        @endif
                        <form action="{{ url('mechanic/' . $mechanic->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label>Nama Montir</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $mechanic->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>NIK Montir <code>[opsional]</code></label>
                                <input type="text" class="form-control  @error('nin') is-invalid @enderror" name="nin"
                                    value="{{$mechanic->nin }}" >
                                    @error('nin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>No. Telp/HP Montir <code>[opsional]</code></label>
                                <input type="number" class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ $mechanic->phone }}" >
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Alamat Montir <code>[opsional]</code></label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                    >{{ $mechanic->address }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Foto Montir <code>[opsional]</code></label>
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ $mechanic->photo_url }}" alt="photo" class="img-fluid">
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
                                <label>Status Montir</label>
                                <select class="form-control @error('is_active') is-invalid @enderror" name="is_active"
                                    required>
                                    <option @if ($mechanic->is_active == "1") selected @endif value="1">Aktif</option>
                                    <option @if ($mechanic->is_active == "0") selected @endif value="0">Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <span class="invalid-feedback" role="alert">
                                       {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ url('mechanic') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
