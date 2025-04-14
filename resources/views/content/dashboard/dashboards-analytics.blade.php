@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('judul1', 'Home')
@section('judul2', 'Welcome')

@section('vendor-style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}"> --}}
@endsection

@section('vendor-script')
    {{-- <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js?v=12') }}"></script> --}}
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if ($chart != 'line')
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: '{{ $chart }}',
                data: {
                    labels: ['{{ $hari }}'],
                    datasets: [{
                            label: 'Belum Absen',
                            data: [{!! $belumabsen !!}],
                            backgroundColor: 'grey',
                            borderColor: 'grey',
                            borderWidth: 2
                        },
                        {
                            label: 'Hadir',
                            data: [{{ $hadir }}],
                            backgroundColor: 'green',
                            borderColor: 'green',
                            borderWidth: 1
                        },
                        {
                            label: 'Sakit',
                            data: [{{ $sakit }}],
                            backgroundColor: 'lightblue',
                            borderColor: 'lightblue',
                            borderWidth: 1
                        },
                        {
                            label: 'Izin',
                            data: [{{ $izin }}],
                            backgroundColor: 'gold',
                            borderColor: 'gold',
                            borderWidth: 1
                        }
                    ],

                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    },
                    scales: {
                        // y: { // defining min and max so hiding the dataset does not change scale range
                        //     min: 0,
                        //     max: 100
                        // }
                    }
                }
            });
        </script>
    @else
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Belum Absen', 'Hadir', 'Izin', 'Sakit'],
                    datasets: [{
                        label: '{{ $hari }}',
                        data: {!! json_encode($data) !!},
                        backgroundColor: 'purple',
                        borderColor: 'purple',
                        borderWidth: 2
                    }],

                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    },
                    scales: {
                        // y: { // defining min and max so hiding the dataset does not change scale range
                        //     min: 0,
                        //     max: 100
                        // }
                    }
                }
            });
        </script>
    @endif
@endsection

@section('content')
    <div class="row gy-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-1">Form Chart</h5>
                </div>
                <form action="{{ url()->current() }}" method="get">
                    <div class="card-body">
                        <div class='form-group'>
                            <label for='fortanggal' class='text-capitalize'>Tanggal</label>
                            <input type='date' name='tanggal' value="{{ $tanggal }}" id='fortanggal'
                                class='form-control' placeholder='masukan tanggal'>
                        </div>
                        <div class='form-group'>
                            <label for='forchart' class='text-capitalize'>Type Chart</label>
                            <select name='chart' id='forchart' class='form-control'>
                                <option value='bar' @if ($chart == 'bar') selected @endif>Diagram Batang
                                </option>
                                <option value='line' @if ($chart == 'line') selected @endif>Diagram Garis
                                </option>
                                <option value='pie' @if ($chart == 'pie') selected @endif>Diagram Lingkaran
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <button type="submit" class="btn btn-outline-success w-100">
                            Proses
                        </button>
                    </div>

                </form>
            </div>

        </div>


        <!-- Weekly Overview Chart -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Chart Harian</h5>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="myChart" style="max-height: 350px"></canvas>

                </div>
            </div>
        </div>
    </div>
@endsection
