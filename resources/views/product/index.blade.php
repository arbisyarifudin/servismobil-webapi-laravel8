@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Produk</h2>
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
                                        <th>Harga</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product as $item)
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
                                                <img src="{{ $item->picture_url }}" alt="picture" class="img-fluid">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->category ? $item->category->name : '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{$label}}">
                                                    {{ $item->is_active == 1 ? "Aktif" : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ url('product/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info">Ubah</a>
                                                <form action="{{ url('product/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($product) < 1)
                                        <tr>
                                            <td colspan="5" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ url('product/create') }}" class="btn btn-primary"><span
                                        class="oi oi-plus"></span> Tambah </a>
                                <a href="{{ url('category') }}" class="btn btn-success">
                                    <span class="oi oi-tag"></span> Lihat Kategori
                                </a>
                            </div>
                            {{ $product->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
