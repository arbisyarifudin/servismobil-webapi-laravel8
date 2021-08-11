@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="cardd">
                    {{-- <div class="cardd-header">{{ __('Dashboard') }}</div> --}}



                    <div class="cardd-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h4 class="mb-4">Selamat datang, {{ Auth::user()->name }}!</h4>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6 class="mb-0">Total Paket Layanan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4>Total</h4>
                                            <h3>{{ $tot_paket }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6 class="mb-0">Total Customer</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4>Total</h4>
                                            <h3>{{ $tot_customer }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow-sm">
                                    <div class="card-header">
                                        <h6 class="mb-0">Total Pendapatan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h4>Rp</h4>
                                            <h3>{{ number_format($tot_pendapatan, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm mb-4 d-print-none">
                            <form action="" method="GET">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mr-3 mb-0">Statistik</h5>
                                    <div class="row align-items-center" style="min-width: 80%">
                                        @csrf
                                        <div class="col-md-5">
                                            <select name="bulan" class="form-control">
                                                @foreach ($months as $item)
                                                    <option {{ $bulan_filter == $item->number ? 'selected' : '' }}
                                                        value="{{ $item->number }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="tahun" class="form-control">
                                                @foreach ($years as $item)
                                                    <option {{ $tahun_filter == $item->year ? 'selected' : '' }}
                                                        value="{{ $item->year }}">{{ $item->year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary "><i class="fas fa-search"></i>
                                                Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                <canvas id="statistik"></canvas>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var bulan = <?= $bulan ?>;
        var reservasi = <?= $reservasi ?>;
        var servis = <?= $servis ?>;
        document.addEventListener("DOMContentLoaded", function() {
            var chartdata = {
                labels: bulan,
                datasets: [{
                        label: 'Total Reservasi',
                        backgroundColor: 'rgba(26, 187, 156, 0.4)',
                        borderColor: 'rgba(26, 187, 156, 0.7)',
                        hoverBackgroundColor: 'rgba(26, 187, 156, 0.6)',
                        hoverBorderColor: 'rgba(26, 187, 156, 1)',
                        lineTension: 0.2,
                        data: reservasi
                    },
                    {
                        label: 'Total Servis',
                        backgroundColor: 'rgba(255, 99, 132, 0.4)',
                        borderColor: 'rgba(255, 99, 132, 0.7)',
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.6)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)',
                        lineTension: 0.2,
                        data: servis
                    }
                ]
            };

            var ctx = $("#statistik");

            var barGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        });
    </script>
@endpush
