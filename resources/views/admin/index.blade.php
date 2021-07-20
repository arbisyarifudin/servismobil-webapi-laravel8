@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Karyawan</h2>
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
                                        <th>NIK</th>
                                        <th>Telp/HP</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Level</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admin as $item)
                                    @php
                                    if($item->is_active == 1) {
                                        $label =  'success';
                                    } else {
                                        $label =  'secondary';
                                    }
                                    @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <img src="{{ $item->photo_url }}" alt="photo" class="img-fluid">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->username }}</td>
                                            <td>{{ $item->nin ?? '-' }}</td>
                                            <td>{{ $item->phone ?? '-' }}</td>
                                            <td>{{ $item->address ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{$label}}">
                                                    {{ $item->is_active == 1 ? "Aktif" : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>{{ $item->level }}</td>
                                            <td>
                                                <a href="{{ url('admin/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info">Ubah</a>
                                                <form action="{{ url('admin/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($admin) < 1)
                                        <tr>
                                            <td colspan="7" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url('admin/create') }}" class="btn btn-primary"><span
                                        class="oi oi-plus"></span> Tambah </a>
                            {{ $admin->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
