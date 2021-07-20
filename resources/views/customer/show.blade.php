@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('content')

    <div class="container">
        <div class="row justify-content-center mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2>Detail Pelanggan / #{{ $customer->id }}</h2>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Nama</th>
                                    <td width="20">:</td>
                                    <td>{{ $customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>:</td>
                                    <td>{{ $customer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>:</td>
                                    <td>{{ $customer->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP/Telp</th>
                                    <td>:</td>
                                    <td>{{ $customer->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>:</td>
                                    <td>{{ $customer->address ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ url('customer') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ $customer->photoUrl }}" alt="photo" class="img-fluid"
                            style="max-height: 350px; width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h3>Kendaraan Pelanggan</h3>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kendaraan</th>
                                        <th>Brand/Merek</th>
                                        <th>Tahun</th>
                                        <th>Nomor Polisi</th>
                                        <th>Nomor Rangka</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vehicles as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->brand }}</td>
                                            <td>{{ $item->year }}</td>
                                            <td>{{ $item->plate_number }}</td>
                                            <td>{{ $item->chassis_number }}</td>
                                            <td>
                                                <a title="Ubah" data-toggle="tooltip"
                                                    href="{{ url('vehicle/' . $item->id . '/edit?ref_customer=' . $customer->id . '&ref=' . url()->current()) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <form
                                                    action="{{ url('vehicle/' . $item->id . '?ref=' . url()->current()) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button title="Hapus" data-toggle="tooltip"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($vehicles) <= 0)
                                        <tr>
                                            <td colspan="7" class="text-center">Data kendaraan pelanggan ini kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <hr>
                            <a href="{{ url('vehicle/create?ref_customer=' . $customer->id . '&ref=' . url()->current()) }}"
                                class="btn btn-primary"><i class="fa fa-plus"></i>
                                Tambah Kendaraan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
