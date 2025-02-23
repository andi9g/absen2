@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan')
@section('judul1', 'Perangkat')
@section('judul2', 'Absensi')

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


    <div class="row mb-3">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <!-- Modal trigger button -->
                    <button type="button" class="btn btn-primary btn-lg btn-block w-100" data-bs-toggle="modal"
                        data-bs-target="#tambahPerangkat">
                        Tambah Perangkat
                    </button>

                    <!-- Modal Body -->
                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                    <div class="modal fade" id="tambahPerangkat" tabindex="-1" data-bs-backdrop="static"
                        data-bs-keyboard="false" role="dialog" aria-labelledby="modaltambahperangkat" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable " role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaltambahperangkat">
                                        Form Tambah Perangkat
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <form action="{{ route('perangkat.store', []) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class='form-group'>
                                            <label for='forfungsi' class='text-capitalize'>Fungsi Alat Sebagai</label>
                                            <select name='fungsi' id='forfungsi' class='form-control'>
                                                <option value='pengelola'>PENGELOLA</option>
                                                <option value='absensi'>ABSENSI</option>
                                                <select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-success">TAMBAH</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Alat Kelola</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Kode Alat</th>
                                    <th>Detail</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pengelola as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodealat }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="badge bg-info border-0 py-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showalatabsensi{{ $item->idalatabsensi }}">
                                                <i class="mdi mdi-eye"></i> Show Detail
                                            </button>



                                        </td>
                                        <td>
                                            <form action="{{ route('perangkat.destroy', [$item->idalatabsensi]) }}"
                                                id="deleteForm{{ $item->idalatabsensi }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge bg-danger border-0 py-1"
                                                    onclick="confirmDelete{{ $item->idalatabsensi }}()">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>
                                        </td>

                                        <script>
                                            function confirmDelete{{ $item->idalatabsensi }}() {
                                                Swal.fire({
                                                    title: 'Yakin ingin menghapus?',
                                                    text: 'Data akan hilang permanen!',
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
                                                        document.getElementById('deleteForm{{ $item->idalatabsensi }}').submit();
                                                    }
                                                });
                                            }
                                        </script>


                                        <!-- Modal -->
                                        <div class="modal fade" id="showalatabsensi{{ $item->idalatabsensi }}"
                                            tabindex="-1" role="dialog" aria-labelledby="showall" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showall">
                                                            DETAIL PERANGKAT KELOLA
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class='form-group'>
                                                            <label for='forkodealat' class='text-capitalize'>Akses</label>
                                                            <input type='text' disabled id='forkodealat'
                                                                class='form-control'
                                                                value="{{ $item->fungsi == 'absensi' ? 'ABSENSI SISWA' : 'PENGELOLA' }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label for='forkodealat' class='text-capitalize'>Kode
                                                                Alat</label>
                                                            <input type='text' disabled id='forkodealat'
                                                                class='form-control' value="{{ $item->kodealat }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label for='fortimestamp'
                                                                class='text-capitalize'>Timestamp</label>
                                                            <input type='text' disabled id='fortimestamp'
                                                                class='form-control' value="{{ $item->timestamp }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Alat Absensi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Kode Alat</th>
                                    <th>kode alat</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodealat }}</td>
                                        <td>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="badge bg-info border-0 py-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#showalatabsensi{{ $item->idalatabsensi }}">
                                                <i class="mdi mdi-eye"></i> Show Detail
                                            </button>
                                        </td>
                                        <td>
                                            <form action="{{ route('perangkat.destroy', [$item->idalatabsensi]) }}"
                                                id="deleteForm{{ $item->idalatabsensi }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge bg-danger border-0 py-1"
                                                    onclick="confirmDelete{{ $item->idalatabsensi }}()">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>

                                        </td>

                                        <script>
                                            function confirmDelete{{ $item->idalatabsensi }}() {
                                                Swal.fire({
                                                    title: 'Yakin ingin menghapus?',
                                                    text: 'Data akan hilang permanen!',
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
                                                        document.getElementById('deleteForm{{ $item->idalatabsensi }}').submit();
                                                    }
                                                });
                                            }
                                        </script>

                                        <!-- Modal -->
                                        <div class="modal fade" id="showalatabsensi{{ $item->idalatabsensi }}"
                                            tabindex="-1" role="dialog" aria-labelledby="showall" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showall">
                                                            DETAIL PERANGKAT KELOLA
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class='form-group'>
                                                            <label for='forkodealat' class='text-capitalize'>Akses</label>
                                                            <input type='text' disabled id='forkodealat'
                                                                class='form-control'
                                                                value="{{ $item->fungsi == 'absensi' ? 'ABSENSI SISWA' : 'PENGELOLA' }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label for='forkodealat' class='text-capitalize'>Kode
                                                                Alat</label>
                                                            <input type='text' disabled id='forkodealat'
                                                                class='form-control' value="{{ $item->kodealat }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>

                                                        <div class='form-group'>
                                                            <label for='fortimestamp'
                                                                class='text-capitalize'>Timestamp</label>
                                                            <input type='text' disabled id='fortimestamp'
                                                                class='form-control' value="{{ $item->timestamp }}"
                                                                placeholder='masukan namaplaceholder'>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
