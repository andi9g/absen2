@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan Sekolah/Instansi')
@section('open', 'open')
@section('judul1', 'Pengaturan')
@section('judul2', 'Instansi')

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
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">INSTANSI/SEKOLAH</h4>
                    <p class="card-text">FORMULIR</p>

                </div>
                <form action="{{ route('instansi.update', [$instansi->idinstansi]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="forinstansi" class="form-label">Nama Instansi/Sekolah</label>
                            <input type="text" name="namainstansi" id="forinstansi" class="form-control"
                                placeholder="masukan nama instansi/sekolah" value="{{ $instansi->namainstansi ?? '' }}"
                                aria-describedby="helpId" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block w-100">UPDATE</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection
