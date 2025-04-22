@extends('layouts/contentNavbarLayout')

@section('title', 'Cetak - Laporan')

@section('judul1', 'Laporan')
@section('judul2', 'Cetak')



@section('content')

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class='card'>
                <form action="{{ route('cetak-laporan') }}" method="GET" target="_blank">
                    <div class='card-body'>
                        <h5 class='product-title'>FORM CETAK LAPORAN</h5>
                        <p class='product-date'>Inputan semua wajib diinputkan</p>

                        <div class='form-group'>
                            <label for='forkelas' class='text-capitalize'>Kelas</label>
                            <select name='kelas' id='forkelas' required class='form-control'>
                                <option value=''>Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idkelas }}">{{ $item->namakelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='forjurusan' class='text-capitalize'>jurusan</label>
                            <select name='jurusan' id='forjurusan' required class='form-control'>
                                <option value=''>Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->idjurusan }}">{{ $item->namajurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='fortanggalawal' class='text-capitalize'>Tanggal Awal</label>
                            <input type='date' required name='tanggalawal' id='fortanggalawal' class='form-control'
                                placeholder='masukan tanggal awal'>
                        </div>

                        <div class='form-group'>
                            <label for='fortanggalakhir' class='text-capitalize'>Tanggal Akhir</label>
                            <input type='date' required name='tanggalakhir' id='fortanggalakhir' class='form-control'
                                placeholder='masukan tanggal akhir'>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block w-100">Cetak</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
