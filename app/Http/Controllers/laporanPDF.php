<?php

namespace App\Http\Controllers;

use App\Models\absenM;
use App\Models\instansiM;
use App\Models\jurusanM;
use App\Models\kelasM;
use App\Models\kelolawaktuM;
use App\Models\siswaM;
use \Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class laporanPDF extends Controller
{
  public function laporan(Request $request)
  {
    $kelas = kelasM::whereNot("namakelas", "LULUS")
      ->where("idinstansi", $request->idinstansi)
      ->get();
    $jurusan = jurusanM::where("idinstansi", $request->idinstansi)
      ->get();

    return view("pages.laporan.laporan", [
      "kelas" => $kelas,
      "jurusan" => $jurusan,
    ]);
  }

  public function cetak(Request $request)
  {
    $tanggalawal = $request->tanggalawal;
    $tanggalakhir = $request->tanggalakhir;

    $instansi = instansiM::where("idinstansi", $request->idinstansi)->first();

    $kelas = $request->kelas;
    $jurusan = $request->jurusan;
    $idinstansi = $request->idinstansi;
    $siswas = siswaM::where("idinstansi", $idinstansi)
      ->where("idkelas", $kelas)
      ->where("idjurusan", $jurusan)
      ->orderBy("namasiswa", "asc")
      ->get();


    $waktu = kelolawaktuM::where("idinstansi", $idinstansi)->first();


    $dataAbsen = [];
    foreach ($siswas as $siswa) {

      $H = 0;
      $S = 0;
      $I = 0;
      $A = 0;
      $T = 0;
      $hadir = [];
      $tanggals = CarbonPeriod::create($tanggalawal, $tanggalakhir);

      $coba1 = 0;
      $coba2 = 0;
      foreach ($tanggals as $tanggal) {
        $absen = absenM::where("idinstansi", $idinstansi)
          ->where("nisn", sprintf("%010s", $siswa->nisn))
          ->where("tanggal", $tanggal->format("Y-m-d"))
          ->orderBy("tanggal", "asc");

        if ($absen->count() > 0) {
          $H = $H + (($absen->first()->ket == "H") ? 1 : 0);
          $S = $S + (($absen->first()->ket == "S") ? 1 : 0);
          $I = $I + (($absen->first()->ket == "I") ? 1 : 0);
          $A = $A + (($absen->first()->ket == "A") ? 1 : 0);


          $jammasuk = strtotime(
            '-15 minute',
            strtotime(date('Y-m-d') . ' ' . $absen->first()->jammasuk),
          );
          $jadwaljammasuk = strtotime(date('Y-m-d') . ' ' . $waktu->jammasuk);
          // Hitung selisih waktu (dalam detik)
          $selisihDetik = $jammasuk - $jadwaljammasuk;

          // Konversi detik ke jam dan menit
          $jam = floor($selisihDetik / 3600);
          $menit = floor(($selisihDetik % 3600) / 60);
          $detik = $selisihDetik % 60;

          if ($absen->first()->ket == 'H') {
            if ($selisihDetik > 0) {
              $T++;
            }
          }
        } else {
          $H = $H + 0;
          $S = $S + 0;
          $I = $I + 0;
          $A++;
          $T = $T + 0;
        }
      }

      $hadir[] = [
        "H" => $H,
        "S" => $S,
        "I" => $I,
        "A" => $A,
        "T" => $T,
      ];


      $dataAbsen[] = [
        "namasiswa" => $siswa->namasiswa,
        "ket" => $hadir,
      ];
    }

    // dd($dataAbsen);

    $pdf = PDF::loadView("pages.laporan.cetak", [
      "instansi" => $instansi,
      "tanggalawal" => $tanggalawal,
      "tanggalakhir" => $tanggalakhir,
      "dataAbsen" => $dataAbsen,
    ]);
    return $pdf->stream("laporan.pdf");
  }
}
