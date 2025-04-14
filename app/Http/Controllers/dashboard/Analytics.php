<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\absenM;
use App\Models\siswaM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Analytics extends Controller
{
  public function index(Request $request)
  {
    $chart = empty($request->chart) ? 'bar' : $request->chart;
    $tanggal = empty($request->tanggal) ? date("Y-m-d") : $request->tanggal;
    $idinstansi = $request->idinstansi;

    $hari = Carbon::parse($tanggal)->isoFormat("dddd, DD MMMM Y");

    $absen = absenM::where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->selectRaw("LPAD(nisn, 10, '0') as nisn")
      ->pluck("nisn")
      ->toArray();

    $hadir = absenM::where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->where("ket", "H")->count();
    $sakit = absenM::where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->where("ket", "S")->count();
    $izin = absenM::where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->where("ket", "I")->count();

    $belumabsen = siswaM::when(!empty($absen), function ($query) use ($absen) {
      $query->whereNotIn("nisn", $absen);
    })->count();

    $data = [];
    if ($chart == 'line') {
      $data[] = $belumabsen;
      $data[] = $hadir;
      $data[] = $izin;
      $data[] = $sakit;
    }



    return view('content.dashboard.dashboards-analytics', [
      "chart" => $chart,
      "hari" => $hari,
      "tanggal" => $tanggal,

      "belumabsen" => $belumabsen,
      "hadir" => $hadir,
      "sakit" => $sakit,
      "izin" => $izin,
      "data" => $data,
    ]);
  }
}
