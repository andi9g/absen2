@extends('layouts/contentNavbarLayout')

@section('title', 'Registrasi Kartu Pelajar')
@section('judul1', 'Menu')
@section('judul2')
    Absensi Siswa
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


    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="kehadiranManual" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">
                        Form Kehadiran Manual
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('absen.store', []) }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        @livewire('get-siswa')

                        <div class='form-group'>
                            <label for='fortanggal' class='text-capitalize'>Tanggal</label>
                            <input type='date' value="{{ $tanggal }}" name='tanggal' id='fortanggal'
                                class='form-control' placeholder='masukan namaplaceholder'>
                        </div>

                        <div class='form-group'>
                            <label for='forket' class='text-capitalize'>Keterangan</label>
                            <select name='ket' id='forket' class='form-control'>
                                @foreach ($keterangan as $ket)
                                    <option value='{{ $ket->keterangan }}'
                                        @if ($ket->keterangan == 'H') selected @endif>
                                        {{ $ket->keterangan }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md">
                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-primary btn-lg w-100 mt-1" data-bs-toggle="modal"
                                        data-bs-target="#kehadiranManual">
                                        ABSENSI MANUAL
                                    </button>

                                    <table class="table table-striped">
                                        <tr>
                                            <td>Hadir : <b>{{ $hadir }}</b></td>
                                            <td>Izin : <b>{{ $izin }}</b></td>
                                            <td>Sakit : <b>{{ $sakit }}</b></td>
                                            <td>Alpa : <b>{{ $alpa }}</b></td>
                                        </tr>

                                    </table>
                                </div>

                            </div>



                        </div>
                        <div class="col-md-8">
                            <form action="{{ url()->current() }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class='form-group'>
                                            <input type='date' name='tanggal' id='' value="{{ $tanggal }}"
                                                onchange="submit()" class='form-control'
                                                placeholder='masukan namaplaceholder'>
                                        </div>
                                        <div class='form-group'>
                                            <select name='kelas' id='forkelas' onchange="submit()" class='form-control'>
                                                <option value=''>Semua Kelas</option>
                                                @foreach ($data_kelas as $k)
                                                    <option value="{{ $k->namakelas }}"
                                                        @if ($k->namakelas == $kelas) selected @endif>
                                                        {{ $k->namakelas }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">

                                        <div class='form-group'>
                                            <select name='jurusan' id='forjurusan' onchange="submit()" class='form-control'>
                                                <option value=''>Semua Jurusan</option>
                                                @foreach ($data_jurusan as $j)
                                                    <option value="{{ $j->jurusan }}"
                                                        @if ($j->jurusan == $jurusan) selected @endif>
                                                        {{ $j->jurusan }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="input-group">
                                            <input class="form-control" type="text" value="{{ $keyword }}"
                                                name="keyword" placeholder="masukan nama siswa"
                                                aria-label="masukan nama siswa" aria-describedby="keyword">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-secondary" id="keyword">
                                                    <i class="fa fa-search"></i> Cari
                                                </button>
                                            </div>
                                        </div>






                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">


                    {{-- <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambah">Content</button> --}}

                    <div class="table-responsive">
                        {{-- {{ $siswa->links('vendor.pagination.bootstrap-4') }} --}}
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Rombel</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th width="5px">Ket</th>
                                    <th>Label</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($absen as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $absen->firstItem() - 1 }}</td>
                                        <td>{{ $item->siswa->detailsiswa->nama ?? '' }}</td>
                                        <td>{{ $item->siswa->kelas->namakelas . ' ' . $item->siswa->jurusan->jurusan }}
                                        </td>
                                        <td>{{ $item->jammasuk }}</td>
                                        <td>{{ $item->jamkeluar }}</td>
                                        @if ($item->ket == 'H')
                                            <td class="text-center" style="background: rgb(170, 255, 170)">
                                                {{ $item->ket }}
                                            </td>
                                        @elseif ($item->ket == 'I')
                                            <td class="text-center" style="background: rgb(248, 250, 162)">
                                                {{ $item->ket }}
                                            </td>
                                        @elseif ($item->ket == 'S')
                                            <td class="text-center" style="background: rgb(191, 251, 255)">
                                                {{ $item->ket }}
                                            </td>
                                        @elseif ($item->ket == 'A')
                                            <td class="text-center" style="background: rgba(255, 186, 186, 0.733)">
                                                {{ $item->ket }}
                                            </td>
                                        @else
                                        @endif

                                        <td>
                                            @php
                                                $jammasuk = strtotime(
                                                    '-15 minute',
                                                    strtotime(date('Y-m-d') . ' ' . $item->jammasuk),
                                                );
                                                $jadwaljammasuk = strtotime(date('Y-m-d') . ' ' . $waktu->jammasuk);
                                                // Hitung selisih waktu (dalam detik)
                                                $selisihDetik = $jammasuk - $jadwaljammasuk;

                                                // Konversi detik ke jam dan menit
                                                $jam = floor($selisihDetik / 3600);
                                                $menit = floor(($selisihDetik % 3600) / 60);
                                                $detik = $selisihDetik % 60;
                                            @endphp
                                            @if ($item->ket == 'H')
                                                @if ($selisihDetik > 0)
                                                    <small class="badge bg-danger py-1 border-0">Terlambat
                                                        {{ $jam }}
                                                        jam {{ $menit }} menit</small>
                                                @elseif(!empty($item->jammasuk))
                                                    <small class="badge bg-success py-1 border-0">Tepat Waktu</small>
                                                @else
                                                    <small class="badge bg-warning py-1 border-0">Tidak absen masuk</small>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

                <div class="card-footer">
                    {{ $absen->links('vendor.pagination.bootstrap-4') }}
                </div>


            </div>
        </div>
    </div>

@endsection
