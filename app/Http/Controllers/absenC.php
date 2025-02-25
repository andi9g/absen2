<?php

namespace App\Http\Controllers;

use App\Models\absenM;
use App\Models\instansiM;
use App\Models\jurusanM;
use App\Models\kelasM;
use App\Models\kelolawaktuM;
use App\Models\keteranganM;
use App\Models\siswaM;
use Illuminate\Http\Request;

class absenC extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    $keyword = empty($request->keyword) ? '' : $request->keyword;
    $kelas = empty($request->kelas) ? '' : $request->kelas;
    $jurusan = empty($request->jurusan) ? '' : $request->jurusan;
    $keterangan = empty($request->keterangan) ? '' : $request->keterangan;
    $tanggal = empty($request->tanggal) ? date("Y-m-d") : $request->tanggal;

    $idinstansi = $request->idinstansi;

    $data_jurusan = jurusanM::where("idinstansi", $idinstansi)->get();
    $data_kelas = kelasM::where("idinstansi", $idinstansi)->get();

    $waktu = kelolawaktuM::where("idinstansi", $idinstansi)->first();

    $keterangan = keteranganM::get();

    $absen = absenM::with(['siswa.detailsiswa', 'siswa.kelas', 'siswa.jurusan'])
      ->whereHas('siswa', function ($query) use ($idinstansi, $keyword, $kelas, $jurusan) {
        $query->where('idinstansi', $idinstansi)
          ->when($keyword, fn($q) => $q->whereHas('detailSiswa', fn($ds) => $ds->where('nama', 'like', "%$keyword%")))
          ->when($kelas, fn($q) => $q->whereHas('kelas', fn($k) => $k->where('namakelas', $kelas)))
          ->when($jurusan, fn($q) => $q->whereHas('jurusan', fn($j) => $j->where('jurusan', $jurusan)));
      })
      ->where('tanggal', $tanggal)
      ->paginate(15);

    $absen->appends($request->only(["limit", "keyword", "jurusan", "kelas", "tanggal"]));


    $hadir = absenM::from("smkngunu_absensi.absen as ad")
      ->join("smkngunu_siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "H")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $izin = absenM::from("smkngunu_absensi.absen as ad")
      ->join("smkngunu_siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "I")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $sakit = absenM::from("smkngunu_absensi.absen as ad")
      ->join("smkngunu_siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "S")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $alpa = absenM::from("smkngunu_absensi.absen as ad")
      ->join("smkngunu_siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "A")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();

    return view("pages.menu.absen", [
      "data_jurusan" => $data_jurusan,
      "data_kelas" => $data_kelas,
      "tanggal" => $tanggal,
      "jurusan" => $jurusan,
      "keyword" => $keyword,
      "absen" => $absen,
      "waktu" => $waktu,
      "kelas" => $kelas,
      "keterangan" => $keterangan,

      "hadir" => $hadir,
      "izin" => $izin,
      "sakit" => $sakit,
      "alpa" => $alpa,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'nisn' => 'required',
      'tanggal' => 'required',
      'ket' => 'required',
    ]);

    try {
      $nisn = sprintf("%010s", $request->nisn);
      $idinstansi = $request->idinstansi;
      $tanggal = $request->tanggal;

      $data = $request->only(["tanggal", "ket"]);
      $data["nisn"] = $nisn;
      $data["jammasuk"] = date("H:i", strtotime(now()));
      $data["jamkeluar"] = date("H:i", strtotime(now()));
      // dd($jammasuk);

      $cek = siswaM::where("nisn", $nisn)->where("idinstansi", $idinstansi)->count();

      if ($cek > 0) {
        $cek2 = absenM::where("nisn", $nisn)->where("tanggal", $tanggal);
        if ($cek2->count() >= 1) {
          $cek2->first()->update([
            "ket" => $data["ket"],
          ]);
        } else {
          absenM::create($data);
        }
      }

      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(absenM $absenM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(absenM $absenM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, absenM $absenM)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(absenM $absenM)
  {
    //
  }
}
