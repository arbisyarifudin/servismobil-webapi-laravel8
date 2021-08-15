@extends('layouts.app')
@section('title', 'Pemberitahuan')
@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Pemberitahuan</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($notifications as $item)
                            <a href="{{ url('notification/open/' . $item->id) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-3
                                    @if (!$item->is_read) bg-light @endif
                                ">
                                @if ($item->type == 'reservations')
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 @if (!$item->is_read) font-weight-bold @endif">Reservasi Baru!</h5>
                                        <small>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</small>
                                    </div>
                                    <p class="mb-1">Ada reservasi servis baru untuk tanggal
                                        <strong>{{ date('d F Y', strtotime($item->reservation->reservation_date)) }}</strong>
                                        pk
                                        <strong>{{ date('H:i', strtotime($item->reservation->reservation_time)) }}</strong>.
                                        {{-- senilai: <strong>Rp 200.000</strong> --}}
                                    </p>
                                @elseif($item->type == 'customers')
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1 font-weight-bold">Customer Baru!</h5>
                                        <small>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</small>
                                    </div>
                                    <p class="mb-1">Anda mendapatkan customer yang baru saja mendaftar via
                                        <b>Aplikasi</b>.
                                        {{-- pada <strong>
                                            {{ date('d F Y, H:i', strtotime($item->customer->created_at)) }}</strong> --}}
                                    </p>
                                @endif
                                <small>Silakan klik untuk membuka</small>
                            </a>
                        @endforeach

                    </div>
                    @if (count($notifications) == 0)
                        <div class="alert alert-info">Pemberitahuan kosong.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
