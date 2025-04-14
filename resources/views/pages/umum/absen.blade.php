<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>DATA KEHADIRAN SISWA</title>

    <style>
        .form-group {
            margin-bottom: 10px;
        }

        .bg-purple {
            background: #b519fd;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-purple">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">KEHADIRAN SISWA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('login', []) }}">Login</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">

                            <div class="col-md-12">
                                <form action="{{ url()->current() }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class='form-group'>
                                                <input type='date' name='tanggal' id=''
                                                    value="{{ $tanggal }}" onchange="submit()" class='form-control'
                                                    placeholder='masukan namaplaceholder'>
                                            </div>
                                            <div class='form-group'>
                                                <select name='kelas' id='forkelas' onchange="submit()"
                                                    class='form-control'>
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
                                                <select name='jurusan' id='forjurusan' onchange="submit()"
                                                    class='form-control'>
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
                                                    @else
                                                        <small class="badge bg-success py-1 border-0">Tepat
                                                            Waktu</small>
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

    </div>


    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">&copy;Copyright by <font class="text-success">SMKN 1 GUNUNG KIJANG</font></span>
        </div>
    </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
