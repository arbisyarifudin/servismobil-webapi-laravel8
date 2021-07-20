@extends('layouts.app')
@section('title', 'Data Kategori')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Data Kategori</h2>
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
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->about }}</td>
                                            <td>
                                                <a href="{{ url('category/' . $item->id . '/edit') }}"
                                                    class="btn btn-sm btn-info">Ubah</a>
                                                <form action="{{ url('category/' . $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button onclick="return confirm('Apakah anda yakin?')"
                                                        class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (count($category) < 1)
                                        <tr>
                                            <td colspan="5" class="text-center">Data kosong.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                           <div>
                            <a href="{{ url('category/create') }}" class="btn btn-primary"><span
                                class="oi oi-plus"></span> Tambah </a>
                                <a href="{{ url('product') }}" class="btn btn-success">
                                    <span class="oi oi-box"></span> Lihat Produk
                                </a>
                           </div>
                            {{ $category->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
