@extends('layouts.app')
@section('title', 'Data Pembayaran')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Pembayaran</h2>
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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Servis</th>
                                        <th>Tagihan</th>
                                        <th>Pembayaran</th>
                                        <th>Kembalian</th>
                                        <th>Penanggungjawab</th>
                                        <th>Tanggal</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td># {{ $item->service->id }}</td>
                                            <td>{{ $item->bill }}</td>
                                            <td>{{ $item->pay }}</td>
                                            <td>{{ $item->change }}</td>
                                            <td>{{ $item->admin->name }}</td>
                                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                            <td>
                                                <a href="{{ url('payment/' . $item->id) }}"
                                                    class="btn btn-sm btn-success">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($payments) < 1)
                                        <tr>
                                            <td colspan="8" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                {{-- <a href="{{ url('payment/create') }}" class="btn btn-primary"><span
                                        class="oi oi-plus"></span> Tambah </a> --}}
                                <a href="{{ url('reservation') }}" class="btn btn-primary btn-sm">
                                    <span class="oi oi-list mr-1"></span> Lihat Reservasi
                                </a>
                            </div>
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
