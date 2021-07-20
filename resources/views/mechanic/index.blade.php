@extends('layouts.app')
@section('title', 'Data Montir')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Montir</h2>
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
                                        <th>NIK</th>
                                        <th>Telp/HP</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mechanic as $item)
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
                                            <td>{{ $item->nin ?? '-' }}</td>
                                            <td>{{ $item->phone ?? '-' }}</td>
                                            <td>{{ $item->address ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{$label}}">
                                                    {{ $item->is_active == 1 ? "Aktif" : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ url('mechanic/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info">Ubah</a>
                                                <form action="{{ url('mechanic/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($mechanic) < 1)
                                        <tr>
                                            <td colspan="7" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ url('mechanic/create') }}" class="btn btn-primary"><span
                                        class="oi oi-plus"></span> Tambah </a>
                            {{ $mechanic->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
