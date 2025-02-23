@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan Kelas')
@section('open', 'open')
@section('judul1', 'Pengaturan')
@section('judul2', 'Kelas')

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
    <!-- Modal -->
    <div class="modal fade" id="tambahkelas" tabindex="-1" role="dialog" aria-labelledby="formtambahkelas" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formtambahkelas">
                        Form Tambah Kelas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.store', []) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class='form-group'>
                            <label for='fornamakelas' class='text-capitalize'>Nama Kelas</label>
                            <input type='text' name='namakelas' id='fornamakelas' class='form-control'
                                placeholder='nama kelas'>
                            <p class="text-danger">Contoh : I, II, III... X, XI, XII</p>
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
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                                data-bs-target="#tambahkelas">
                                Tambah Kelas
                            </button>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ url()->current() }}">
                                <div class="input-group">
                                    <input class="form-control" type="text" value="{{ $keyword }}" name="keyword"
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
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>
                                </tr>

                            </thead>

                            <tbody>
                                @foreach ($kelas as $item)
                                    <tr>
                                        {{-- <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td> --}}
                                        <td width="5px" align="center">{{ $loop->iteration }}</td>
                                        <td>{{ $item->namakelas }}</td>
                                        <td nowrap align="center" width="5px">
                                            <form action="{{ route('kelas.destroy', [$item->idkelas]) }}"
                                                id="deleteForm{{ $item->idkelas }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="badge bg-danger border-0 py-1"
                                                    onclick="confirmDelete{{ $item->idkelas }}()">
                                                    <i class="mdi mdi-trash-can-outline"></i>
                                                </button>
                                            </form>

                                            {{-- //wait --}}
                                            <button type="button" class="badge bg-primary border-0 py-1"
                                                data-bs-toggle="modal" data-bs-target="#editkelas{{ $item->idkelas }}">
                                                <i class="mdi mdi-pencil-outline"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <script>
                                        function confirmDelete{{ $item->idkelas }}() {
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
                                                    document.getElementById('deleteForm{{ $item->idkelas }}').submit();
                                                }
                                            });
                                        }
                                    </script>

                                    <div class="modal fade" id="editkelas{{ $item->idkelas }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId">
                                                        Modal title
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('kelas.update', [$item->idkelas]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class='form-group'>
                                                            <label for='fornamakelas' class='text-capitalize'>Nama
                                                                Kelas</label>
                                                            <input type='text' name='namakelas' id='fornamakelas'
                                                                class='form-control' value="{{ $item->namakelas }}"
                                                                placeholder='nama kelas'>
                                                            <p class="text-danger">Contoh : I, II, III... X, XI, XII</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">UBAH</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        var editkelas{{ $item->idkelas }} = document.getElementById('editkelas{{ $item->idkelas }}');

                                        editkelas{{ $item->idkelas }}.addEventListener('show.bs.modal', function(event) {
                                            // Button that triggered the modal
                                            let button = event.relatedTarget;
                                            // Extract info from data-bs-* attributes
                                            let recipient = button.getAttribute('data-bs-whatever');

                                            // Use above variables to manipulate the DOM
                                        });
                                    </script>


                                    <div id="editkelas{{ $item->idkelas }}{{ $item->idkelas }}" class="modal fade"
                                        tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">Title</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('kelas.update', [$item->idkelas]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class='form-group'>
                                                            <label for='fornamakelas' class='text-capitalize'>Nama
                                                                Kelas</label>
                                                            <input type='text' name='namakelas' id='fornamakelas'
                                                                class='form-control' value="{{ $item->namakelas }}"
                                                                placeholder='nama kelas'>
                                                            <p class="text-danger">Contoh : I, II, III... X, XI, XII</p>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Tambah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>


            </div>

        </div>
    </div>
@endsection
