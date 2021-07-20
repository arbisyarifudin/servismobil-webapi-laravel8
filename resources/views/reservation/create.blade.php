@extends('layouts.app')
@section('title', 'Input Reservasi')
@section('content')

    <div class="container" id="app">
        <div class="row justify-content-center mb-3">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h2>Input Reservasi</h2>
                        <hr>
                        <form action="{{ url('reservation') }}" method="POST">
                            @csrf
                            <div>
                                <input-reservation />
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
