@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan Jurusan')
@section('open', 'open')
@section('judul1', 'Pengaturan')
@section('judul2', 'Jurusan')

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
    <div class="modal fade" id="tambahjurusantauruang" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="tambahjurusanatauruang" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahjurusanatauruang">
                        Form Tambah Jurusan/Ruang
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jurusan.store', []) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class='form-group'>
                            <label for='forjurusan' class='text-capitalize'>Inisial Jurusan/Ruangan</label>
                            <input type='text' name='jurusan' id='forjurusan' class='form-control'
                                placeholder='masukan inisial jurusan'>
                            <p class="text-danger">Contoh (SMK : TKJ, DPIB, RPL) / (SD s.d SMA : A, B, A1..)</p>
                        </div>
                        <div class='form-group'>
                            <label for='fornamajurusan' class='text-capitalize'>Nama Jurusan</label>
                            <input type='text' name='namajurusan' id='fornamajurusan' class='form-control'
                                placeholder='nama jurusan'>
                            <p class="text-danger">Contoh <br> SMK : Teknik Komputer dan Jaringan <br> SD s.d SMA : Sama
                                dengan Inisial Jurusan/Ruangan</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Modal trigger button -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahjurusantauruang">
                                Tambah Jurusan/Ruang
                            </button>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ url()->current() }}">
                                <div class="input-group">
                                    <input class="form-control nm" type="text" value="{{ $keyword }}" name="keyword"
                                        placeholder="search..." aria-label="masukan nama siswa" aria-describedby="keyword">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary" id="keyword">
                                            <i class="fa fa-search"></i> Cari
                                        </button>
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
                        <table class="table table-striped table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Inisial Jurusan</th>
                                    <th>Nama Jurusan</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($jurusan as $item)
                                    <tr>
                                        {{-- <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td> --}}
                                        <td width="5px" align="center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->jurusan ?? '' }}</td>
                                        <td>{{ $item->namajurusan }}</td>
                                        <td nowrap align="center" width="5px">
                                            <form action="{{ route('jurusan.destroy', [$item->idjurusan]) }}"
                                                id="deleteForm{{ $item->idjurusan }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge bg-danger border-0 py-1"
                                                    onclick="confirmDelete{{ $item->idjurusan }}()">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>


                                            <!-- Modal trigger button -->
                                            <button type="button" class="badge bg-primary border-0 py-1"
                                                data-bs-toggle="modal" data-bs-target="#editjurusan{{ $item->idjurusan }}">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </button>

                                            <!-- Modal Body -->
                                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                            <div class="modal fade" id="editjurusan{{ $item->idjurusan }}" tabindex="-1"
                                                data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                aria-labelledby="tambahjurusanatauruang" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahjurusanatauruang">
                                                                Form Tambah Jurusan/Ruang
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('jurusan.update', [$item->idjurusan]) }}"
                                                            method="POST" style="text-align: left">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-body">
                                                                <div class='form-group'>
                                                                    <label for='forjurusan'
                                                                        class='text-capitalize'>Inisial
                                                                        Jurusan/Ruangan</label>
                                                                    <input type='text' name='jurusan'
                                                                        value="{{ $item->jurusan }}" id='forjurusan'
                                                                        class='form-control'
                                                                        placeholder='masukan inisial jurusan'>
                                                                    <p class="text-danger">Contoh (SMK : TKJ, DPIB, RPL) /
                                                                        (SD s.d SMA : A, B, A1..)
                                                                    </p>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label for='fornamajurusan'
                                                                        class='text-capitalize'>Nama Jurusan</label>
                                                                    <input type='text' name='namajurusan'
                                                                        id='fornamajurusan'
                                                                        value="{{ $item->namajurusan }}"
                                                                        class='form-control' placeholder='nama jurusan'>
                                                                    <p class="text-danger">Contoh <br> SMK : Teknik
                                                                        Komputer dan Jaringan <br> SD s.d SMA : Sama
                                                                        dengan Inisial Jurusan/Ruangan</p>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-success">UBAH</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>





                                        </td>
                                    </tr>

                                    <script>
                                        function confirmDelete{{ $item->idjurusan }}() {
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
                                                    document.getElementById('deleteForm{{ $item->idjurusan }}').submit();
                                                }
                                            });
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
