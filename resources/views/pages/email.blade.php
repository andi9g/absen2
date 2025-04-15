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

    <div class="modal fade" id="tambahinstansi" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="formTambahInstansi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTambahInstansi">
                        Form Tambah Instansi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    asdasd
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("tambahinstansi"),
            options,
        );
    </script>



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-7">
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                data-bs-target="#tambahinstansi">
                                Tambah Instansi
                            </button>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input class="form-control" type="text" value="{{ empty($keyword) ?? '' }}" name="keyword"
                                    placeholder="masukan nama siswa" aria-label="masukan nama siswa"
                                    aria-describedby="keyword">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary" id="keyword">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5px">No</th>
                                <th>Nama Instansi</th>
                                <th>NPSN</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instansi as $item)
                                <tr>
                                    <td align="center">{{ $loop->iteration + $instansi->firstItem() - 1 }}</td>
                                    <td>{{ $item->namainstansi }}</td>
                                    <td>{{ $item->npsn }}</td>
                                    <td>
                                        <form action="{{ route('akun.destroy', [$item->idinstansi]) }}"
                                            id="deleteForm{{ $item->idinstansi }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="badge bg-danger border-0 py-1"
                                                onclick="confirmDelete{{ $item->idinstansi }}()">
                                                <i class="mdi mdi-trash-can-outline"></i>
                                            </button>
                                        </form>




                                    </td>
                                </tr>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#modalId">
                                    <i class="mdi mdi-pencil"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalId" tabindex="-1" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitleId">
                                                    Form Edit Data
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container-fluid">Add rows here</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    var modalId = document.getElementById('modalId');

                                    modalId.addEventListener('show.bs.modal', function(event) {
                                        // Button that triggered the modal
                                        let button = event.relatedTarget;
                                        // Extract info from data-bs-* attributes
                                        let recipient = button.getAttribute('data-bs-whatever');

                                        // Use above variables to manipulate the DOM
                                    });
                                </script>



                                <script>
                                    function confirmDelete{{ $item->idinstansi }}() {
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
                                                document.getElementById('deleteForm{{ $item->idinstansi }}').submit();
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


@endsection
