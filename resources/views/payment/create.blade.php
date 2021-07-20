@extends('layouts.app')
@section('title', 'Input Pembayaran')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" id="app">
                        <h2>Input Pembayaran</h2>
                        <hr>
                        <form action="{{ url('payment?service_id=' . request()->query('service_id')) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @if (request()->query('service_id') && !empty(request()->query('service_id')))
                                <div class="mb-3">
                                    {{-- <label>Servis</label> --}}
                                    <input type="hidden" name="service_id" value="{{ request()->query('service_id') }}">
                                </div>
                            @else
                                <div class="mb-3">
                                    <label>Pilih Servis</label>
                                    <select class="form-control @error('service_id') is-invalid @enderror" name="service_id"
                                        required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($services as $item)
                                            <option @if (old('service_id') == $item->id) selected @endif value="{{ $item->id }}">
                                                {{ $item->id }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pelanggan</label>
                                    <div class="h5">{{ $reservation->customer->name }}</div>
                                    <div class="small">No. HP/Telp: {{ $reservation->customer->phone ?? '-' }}</div>
                                    <div class="small">Alamat: {{ $reservation->customer->address ?? '-' }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Kendaraan</label>
                                    <div class="h5">{{ $vehicle->name }}</div>
                                    <div class="small">Nopol: {{ $vehicle->plate_number }}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="h6">ID Servis: #
                                        {{ str_pad($reservation->service->id, 5, '0', STR_PAD_LEFT) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="h6">Tgl. Servis:
                                        {{ date('d/m/Y', strtotime($reservation->service->service_date)) }}</div>
                                    {{-- <div class="h6">Paket Layanan: {{ $reservation->package->name }}</div> --}}
                                </div>
                            </div>
                            <hr>
                            <payment-input
                                :bill="{{ request()->query('package_price') + request()->query('service_fee') }}">
                                <slot>
                                    @if (request()->query('reservation_id') && !empty(request()->query('reservation_id')))
                                        <a href="{{ url('reservation/' . request()->query('reservation_id')) }}"
                                            class="btn btn-secondary">Kembali</a>
                                    @else
                                        <a href="{{ url('service') }}" class="btn btn-secondary">Kembali</a>
                                    @endif
                                </slot>
                            </payment-input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
