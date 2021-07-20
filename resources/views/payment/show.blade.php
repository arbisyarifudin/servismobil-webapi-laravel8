@extends('layouts.app')
@section('title', 'Input Pembayaran')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" id="app">
                        <h2>Detail Pembayaran / #{{ $payment->id }}</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Pelanggan</label>
                                <div class="h5">{{ $payment->service->reservation->customer->name }}</div>
                                <div class="small">No. HP/Telp:
                                    {{ $payment->service->reservation->customer->phone ?? '-' }}</div>
                                <div class="small">Alamat: {{ $payment->service->reservation->customer->address ?? '-' }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Kendaraan</label>
                                <div class="h5">{{ $payment->service->reservation->vehicle->name }}</div>
                                <div class="small">Nopol: {{ $payment->service->reservation->vehicle->plate_number }}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="h6">ID Servis: #
                                    {{ str_pad($payment->service->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="h6">Tgl. Servis:
                                    {{ date('d/m/Y', strtotime($payment->service->service_date)) }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="h6">ID Pembayaran: #
                                    {{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="h6">Tgl. Bayar:
                                    {{ date('d/m/Y', strtotime($payment->created_at)) }}</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>Tagihan Servis</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <div class="h3">
                                                        {{ number_format($payment->bill, 0, ',', '.') }}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Pembayaran Pelanggan</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span> {{ number_format($payment->pay, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Kembalian</th>
                                            <th width="10">:</th>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span> {{ number_format($payment->change, 0, ',', '.') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if (request()->query('reservation_id'))
                            <a href="{{ url('reservation/' . request()->query('reservation_id')) }}"
                                class="btn btn-secondary">Kembali</a>
                        @else
                            <a href="{{ url('payment') }}" class="btn btn-secondary">Kembali</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
