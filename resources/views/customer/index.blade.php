@extends('layouts.app')
@section('title', 'Data Pelanggan')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Pelanggan</h2>
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
                                        <th width="100">Foto</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No. Telp/HP</th>
                                        <th>Alamat</th>
                                        {{-- <th>Kendaraan</th> --}}
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customer as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ $item->photo_url }}" alt="photo" class="img-fluid">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                            <td>{{ $item->phone ?? '-' }}</td>
                                            <td>{{ $item->address ?? '-' }}</td>
                                            {{-- <td>{{ count($item->vehicles) }}</td> --}}
                                            <td>
                                                <a title="Detail" data-toggle="tooltip"
                                                    href="{{ url('customer/' . $item->id) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-search"></i></a>
                                                <a title="Ubah" data-toggle="tooltip"
                                                    href="{{ url('customer/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <form action="{{ url('customer/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button title="Hapus" data-toggle="tooltip"
                                                        onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($customer) < 1)
                                        <tr>
                                            <td colspan="9" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ url('customer/create') }}" class="btn btn-primary"><span
                                    class="oi oi-plus"></span> Tambah </a>
                            {{ $customer->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
