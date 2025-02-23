@extends('layouts/contentNavbarLayout')

@section('title', 'Cari Kartu Pelajar')
@section('open', 'open')
@section('judul1', 'Kartu Pelajar')
@section('judul2')
    Cek Kartu
    @empty(!$kodealat)
        ( {{ $kodealat }} )
    @endempty
@endsection

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">

@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form action="{{ url()->current() }}">
                <div class="card">
                    <div class="card-body">
                        <label for="">Silahkan Memilih Perangkat</label>
                        <select class="form-select form-select-lg" name="kodealat" onchange="submit()" id="">
                            <option selected>Pilih Perangkat</option>
                            @foreach ($alatabsensi as $alat)
                                <option @if ($kodealat == $alat->kodealat) selected @endif value="{{ $alat->kodealat }}">
                                    {{ $alat->kodealat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if (!empty($kodealat))
                    @livewire('get-card', ['kodealat' => $kodealat])
                @endif
        </div>
        </form>
    </div>
    </div>

@endsection
