@extends('layouts.app')
@section('title', 'Ubah Kendaraan')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Ubah Kendaraan</h2>
                        <hr>
                        @if (session('flash-success'))
                            <div class="alert alert-success">
                                {{ session('flash-success') }}
                            </div>
                        @endif
                        @if (session('flash-danger'))
                            <div class="alert alert-danger">
                                {{ session('flash-danger') }}
                            </div>
                        @endif
                        <form action="{{ url('vehicle/' . $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            @if (request()->query('ref_customer') && !empty(request()->query('ref_customer')))
                                <div class="mb-3">
                                    <label>Nama Pelanggan</label>
                                    <input type="text" disabled class="form-control" value="{{ $customer->name }}">
                                    <input type="hidden" name="customer_id"
                                        value="{{ request()->query('ref_customer') }}">
                                </div>
                            @else
                                <div class="mb-3">
                                    <label>Milik Pelanggan</label>
                                    <select class="form-control @error('customer_id') is-invalid @enderror"
                                        name="customer_id" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($customers as $item)
                                            <option @if ($item->customer_id == $customer->id) selected @endif value="{{ $item->id }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="mb-3">
                                <label>Nama Kendaraan</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ $vehicle->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Brand/Merek</label>
                                <input type="text" class="form-control  @error('brand') is-invalid @enderror" name="brand"
                                    value="{{ $vehicle->brand }}" required>
                                @error('brand')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Tahun</label>
                                <input type="number" min="1950" max="{{ date('Y') }}"
                                    class="form-control  @error('year') is-invalid @enderror" name="year"
                                    value="{{ $vehicle->year }}" required>
                                @error('year')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Nomor Polisi</label>
                                <input type="text" class="form-control  @error('plate_number') is-invalid @enderror"
                                    name="plate_number" value="{{ $vehicle->plate_number }}" required>
                                @error('plate_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Nomor Rangka</label>
                                <input type="number" class="form-control  @error('chassis_number') is-invalid @enderror"
                                    name="chassis_number" value="{{ $vehicle->chassis_number }}" required>
                                @error('chassis_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @if (request()->query('ref_customer') && !empty(request()->query('ref_customer')))
                                <a href="{{ url('customer/' . request()->query('ref_customer')) }}"
                                    class="btn btn-secondary">Kembali</a>
                            @else
                                <a href="{{ url('vehicle') }}" class="btn btn-secondary">Kembali</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
