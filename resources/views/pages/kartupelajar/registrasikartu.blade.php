@extends('layouts/contentNavbarLayout')

@section('title', 'Registrasi Kartu Pelajar')
@section('judul1', 'Kartu Pelajar')
@section('judul2')
    Registrasi
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
    @empty(!$kodealat)
        <!-- Modal Body -->
        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
        <div class="modal fade" id="registrasikartu" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
            aria-labelledby="registrasikartuID" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registrasikartuID">
                            Form Registrasi Kartu
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('registrasikartu.store', []) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nisn" class="form-label">Masukan NISN</label>
                                <br>
                                <small id="nisnID" class="text-muted">untuk otomatis bisa dengan klik daftar pada tabel
                                    siswa</small>
                                <input type="text" name="nisn" id="id_nis" class="form-control"
                                    placeholder="masukan nisn" aria-describedby="nisnID" />
                            </div>
                            <hr>

                            @livewire('get-u-u-i-d', ['kodealat' => $kodealat])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">DAFTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endempty




    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md">
                                    @empty(!$kodealat)
                                        <button type="button" class="btn btn-primary btn-lg w-100" data-bs-toggle="modal"
                                            data-bs-target="#registrasikartu">
                                            Registrasi Kartu
                                        </button>
                                    @else
                                        <small class="btn btn-outline-warning btn-lg w-100">Silahkan Memilih
                                            Perangkat
                                            Absen</small>
                                    @endempty
                                </div>

                            </div>



                        </div>
                        <div class="col-md-8">
                            <form action="{{ url()->current() }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md">
                                            <select class="form-select form-select-lg" name="kodealat" onchange="submit()"
                                                id="">
                                                <option selected>Pilih Perangkat</option>
                                                @foreach ($alatabsensi as $alat)
                                                    <option @if ($kodealat == $alat->kodealat) selected @endif
                                                        value="{{ $alat->kodealat }}">{{ $alat->kodealat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">

                                        <div class="input-group">
                                            <input class="form-control mb-0" type="text" value="{{ $keyword }}"
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
                        {{ $siswa->links('vendor.pagination.bootstrap-4') }}
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th width="5px">NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Rombel</th>
                                    <th>Ket</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($siswa as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                                        <td>{{ sprintf('%010s', $item->nisn) }}</td>
                                        {{-- <td width="5px" align="center">{{ $loop->iteration }}</td> --}}
                                        <td>{{ $item->detailsiswa->nama ?? '' }}</td>
                                        <td>{{ $item->kelas->namakelas . ' ' . $item->jurusan->jurusan }}</td>
                                        <td width="5px">
                                            <center>
                                                @if (empty($item->kartupelajar))
                                                    <label for=""
                                                        class="badge border border-danger text-danger bg-transparent">Tidak
                                                        Terdaftar</label>
                                                @else
                                                    <label for=""
                                                        class="badge border border-success text-success bg-transparent">Terdaftar</label>
                                                @endif

                                            </center>
                                        </td>
                                        <td>
                                            <button type="button"
                                                onclick="kirim_nis_{{ sprintf('%010s', $item->nisn) }}(this)"
                                                value="{{ sprintf('%010s', $item->nisn) }}"
                                                class="btn btn-xs  btn-success btn-block" data-bs-toggle="modal"
                                                data-bs-target="#registrasikartu"><i class="mdi mdi-id-card"></i>
                                                Card</button>

                                            @if (!empty($item->kartupelajar))
                                                <form
                                                    action="{{ route('registrasikartu.destroy', [sprintf('%010s', $item->nisn)]) }}"
                                                    id="deleteForm{{ sprintf('%010s', $item->nisn) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="badge bg-danger border-0 py-1"
                                                        onclick="confirmDelete{{ sprintf('%010s', $item->nisn) }}()">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </button>
                                                </form>
                                            @endif


                                        </td>
                                    </tr>

                                    <script>
                                        function confirmDelete{{ sprintf('%010s', $item->nisn) }}() {
                                            Swal.fire({
                                                title: 'Yakin ingin menghapus?',
                                                html: 'Kartu pelajar <b>{{ $item->siswa->namasiswa ?? '' }}</b> akan dihapus',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Ya, hapus!',
                                                didOpen: () => {
                                                    document.querySelector('.swal2-container').style.zIndex = '9999';
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById("deleteForm{{ sprintf('%010s', $item->nisn) }}").submit();
                                                }
                                            });
                                        }
                                    </script>

                                    <script>
                                        function kirim_nis_{{ sprintf('%010s', $item->nisn) }}(nis) {
                                            document.getElementById('id_nis').value = nis.value;
                                        }
                                    </script>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>


            </div>
        </div>
    </div>

@endsection
