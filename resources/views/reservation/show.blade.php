@extends('layouts.app')
@section('title', 'Detail Reservasi')
@section('content')

    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-5 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h2>Detail Reservasi / #{{ $reservation->id }} </h2>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Nama Pelanggan</th>
                                    <td width="20">:</td>
                                    <td>{{ $reservation->customer ? $reservation->customer->name : '?' }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP / Telp</th>
                                    <td>:</td>
                                    <td>{{ $reservation->customer ? $reservation->customer->phone : '?' }}</td>
                                </tr>
                                <tr>
                                    <th>Kendaraan</th>
                                    <td>:</td>
                                    <td>{!! $reservation->vehicle ? $reservation->vehicle->name . ' <br> <small><b>Nopol:</b> ' . $reservation->vehicle->plate_number . '</small>' : '?' !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keluhan Kendaraan</th>
                                    <td>:</td>
                                    <td>{{ $reservation->vehicle_complaint }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Reservasi</th>
                                    <td>:</td>
                                    <td>{{ date('d/m/Y', strtotime($reservation->reservation_date)) }} -
                                        {{ date('H:i', strtotime($reservation->reservation_time)) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url('reservation') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <h2 class="d-flex justify-content-between">
                            Paket Layanan
                            @if ($reservation->service->payment)
                                <a href="{{ url('payment/' . $reservation->service->payment->id . '?reservation_id=' . $reservation->id) }}"
                                    class="btn btn-danger"><i class="fa fa-credit-card"></i> Detail Pembayaran</a>
                            @endif
                            
                        </h2>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Paket Layanan</th>
                                    <td>:</td>
                                    <td>{{ $reservation->package ? $reservation->package->name : '?' }}</td>
                                </tr>
                                <tr>
                                    <th>Harga Paket Layanan</th>
                                    <td>:</td>
                                    <td>Rp
                                        <b>{{ $reservation->package ? number_format($reservation->package->products->sum('price'), 0, ',', '.') : '?' }}</b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk/Komponen</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                @if ($reservation->package->products)
                                    <tbody>
                                        @foreach ($reservation->package->products as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Rp</span> <span>{{ $item->priceFormatted }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{ number_format($reservation->package->products->sum('price'), 0, ',', '.') }}</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="3" class="text-center">Kosong.</td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($reservation->service->status != 'Finish')
            <div class="card">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h3>Servis</h3>
                            <hr>
                            {{-- <form action="{{ url('service/' . $reservation->service->id . '/billing') }}" method="POST"> --}}
                            <form action="{{ url('payment/create') }}" method="GET">
                                {{-- @csrf --}}
                                <input type="hidden" name="service_id" value="{{ $reservation->service->id }}">
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label>Montir Servis</label>
                                                <select name="mechanic_id" class="form-control" required>
                                                    <option value="">--Pilih--</option>
                                                    @foreach ($mechanics as $item)
                                                        <option @if ($reservation->service->mechanic && $item->id == $reservation->service->mechanic->id) selected @endif
                                                            value="{{ $item->id }}">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label>Biaya Servis</label>
                                                <input type="hidden" name="package_price"
                                                    value="{{ $reservation->package->products->sum('price') }}">
                                                <input type="number" name="service_fee" class="form-control" value="50000"
                                                    required>
                                                {{-- value="{{ $reservation->service->fee }}" required --}}
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label>Catatan Tambahan <code>[opsional]</code></label>
                                                <textarea name="note" class="form-control"
                                                    placeholder="Masukkan catatan atau komponen servis tambahan jika ada..">{{ $reservation->service->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label>Tanggal Servis Lanjutan</label>
                                                <input type="date" name="next_service_date" class="form-control"
                                                    value="{{ date('Y-m-d', strtotime(date('Y-m-d') . '+ 1 month')) }}"
                                                    required>
                                            </div>
                                            {{-- value="{{ $reservation->service->next_service_date }}" required --}}
                                            <div class="col-12 mb-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-primary btn-block"><i
                                                        class="fa fa-credit-card mr-1"></i>
                                                    Lakukan Penagihan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
