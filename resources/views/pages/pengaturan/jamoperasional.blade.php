@extends('layouts/contentNavbarLayout')

@section('title', 'Pengaturan Jam Operasional')
@section('open', 'open')
@section('judul1', 'Pengaturan')
@section('judul2', 'Jam Operasional')

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
            <form action="{{ route('jamoperasional.store') }}" id="updateForm" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @csrf
                                <button type="button" class="btn btn-success w-100" onclick="confirmUpdate()">
                                    UPDATE WAKTU ABSENSI
                                </button>


                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Jam Masuk</h4>
                                <hr>
                                <div class="mb-3">
                                    <input type="time" name="jammasuk" id="" class="form-control"
                                        placeholder="Masukan Jam Keluar" value="{{ $waktu->jammasuk }}"
                                        aria-describedby="helpId" />
                                    <small id="helpId" class="text-muted">jam masuk, namun tidak menjadi patokan bagi
                                        siswa untuk menunggu jam masuk baru melakukan tab kartu absen, datang lebih cepat
                                        juga
                                        dapat melakukan absen. absen masuk dihitung selama jam absen kurang dari jam
                                        keluar</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Jam Keluar</h4>
                                <hr>
                                <div class="mb-3">
                                    <input type="time" name="jamkeluar" id="" class="form-control"
                                        placeholder="Masukan Jam Keluar" value="{{ $waktu->jamkeluar }}"
                                        aria-describedby="helpId" />
                                    <small id="helpId" class="text-muted">Jam keluar ini merujuk pada saat siswa
                                        melakukan
                                        tab kartu pada alat, jika berada di jam keluar atau lebih maka data yang dikirim
                                        berupa
                                        jam keluar/pulang</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <script>
                function confirmUpdate() {
                    Swal.fire({
                        title: 'Yakin ingin Merubah data?',
                        text: '',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ubah sekarang!',
                        didOpen: () => {
                            document.querySelector('.swal2-container').style.zIndex = '9999';
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('updateForm').submit();
                        }
                    });
                }
            </script>

        </div>
    </div>




@endsection
