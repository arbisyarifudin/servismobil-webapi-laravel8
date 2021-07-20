@extends('layouts.app')
@section('title', 'Data Reservasi')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Reservasi</h2>
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
                        <div class="table-responsive" id="app">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pelanggan</th>
                                        <th>Paket Layanan</th>
                                        <th width="120">Harga Paket</th>
                                        <th width="150">Kendaraan</th>
                                        <th>Keluhan</th>
                                        <th>Tanggal Reservasi</th>
                                        <th>Jam Reservasi</th>
                                        <th>Asal</th>
                                        <th>Status Servis</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservation as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->customer ? $item->customer->name : '?' }}</td>
                                            <td>{{ $item->package ? $item->package->name : '?' }}</td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <span>Rp</span>
                                                    <span>{{ $item->package->products ? number_format($item->package->products->sum('price'), 0, ',', '.') : '' }}</span>
                                                </div>
                                            </td>
                                            <td>{!! $item->vehicle ? $item->vehicle->name . ' <br> <small><b>Nopol:</b> ' . $item->vehicle->plate_number . '</small>' : '?' !!}
                                            </td>
                                            <td>{{ $item->vehicle_complaint }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->reservation_date)) }}</td>
                                            <td>{{ date('H:i', strtotime($item->reservation_time)) }}</td>
                                            <td>{{ $item->reservation_origin == 'Online' ? 'Aplikasi' : 'Manual' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        if ($item->service->status == 'Process') {
                                                            $badge = 'info';
                                                        } elseif ($item->service->status == 'Finish') {
                                                            $badge = 'success';
                                                        } else {
                                                            $badge = 'warning';
                                                        }
                                                    @endphp
                                                    <span class="badge badge-pill badge-{{ $badge }}">&nbsp;</span>
                                                    @if ($item->service->status == 'Finish')
                                                        <span style="min-width: 50px" class="ml-2">Selesai</span>
                                                    @else
                                                        <form class="ml-2" style="min-width: 100px"
                                                            action="{{ url('service/' . $item->service->id . '/status?ref=reservation') }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('put')
                                                            <div>
                                                                <change-service-status :data="{{ $item->service }}" />
                                                            </div>
                                                        </form>
                                                    @endif
                                                </div>
                                                @if ($item->service->mechanic)
                                                    <div class="small mt-1">
                                                        Montir: {{ $item->service->mechanic->name }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a title="Detail" data-toggle="tooltip"
                                                    href="{{ url('reservation/' . $item->id) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-search"></i></a>
                                                @if ($item->service->payment)
                                                    <a title="Pembayaran" data-toggle="tooltip"
                                                        href="{{ url('payment/' . $item->service->payment->id . '?reservation_id=' . $item->id) }}"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-credit-card"></i></a>
                                                @endif
                                                {{-- <a href="{{ url('reservation/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info">Ubah</a> --}}
                                                {{-- <form action="{{ url('reservation/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($reservation) < 1)
                                        <tr>
                                            <td colspan="11" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ url('reservation/create') }}" class="btn btn-primary"><span
                                        class="oi oi-plus"></span> Tambah </a>

                            </div>
                            {{ $reservation->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
