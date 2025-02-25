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

    $absen = absenM::whereHas("siswa", function ($query) use ($keyword, $idinstansi, $kelas, $jurusan) {
      $query->from("smkngunu_siswa.siswa")
        ->where("idinstansi", $idinstansi)
        ->whereHas("detailsiswa", function ($query2) use ($keyword) {
          $query2->from("siswa.detailsiswa")
            ->when($keyword, fn($q) => $q->where('nama', 'like', "%$keyword%"));
        })
        ->whereHas("kelas", function ($query2) use ($kelas) {
          $query2->from("smkngunu_siswa..kelas")
            ->when($kelas, fn($q) => $q->where('namakelas', $kelas));
        })
        ->whereHas("jurusan", function ($query2) use ($jurusan) {
          $query2->from("smkngunu_siswa..jurusan")
            ->when($jurusan, fn($q) => $q->where('jurusan', $jurusan));
        });
    })->where('tanggal', $tanggal)
      ->paginate(15);
    // dd($absen);

    // $absen = absenM::from("smkngunu_absensi.absen as absen")
    //   ->join('smkngunu_siswa.siswa as s', 'absen.nisn', '=', 's.nisn')
    //   ->leftJoin('smkngunu_siswa.detailsiswa as ds', 's.nisn', '=', 'ds.nisn')
    //   ->leftJoin('smkngunu_siswa.kelas as k', 's.idkelas', '=', 'k.idkelas')
    //   ->leftJoin('smkngunu_siswa.jurusan as j', 's.idjurusan', '=', 'j.idjurusan')
    //   ->where('s.idinstansi', $idinstansi)
    //   ->when($keyword, fn($q) => $q->where('ds.nama', 'like', "%$keyword%"))
    //   ->when($kelas, fn($q) => $q->where('k.namakelas', $kelas))
    //   ->when($jurusan, fn($q) => $q->where('j.jurusan', $jurusan))
    //   ->where('absen.tanggal', $tanggal)
    //   ->select('absen.*', 'ds.nama', 'k.namakelas', 'j.jurusan')
    //   ->paginate(1);

    $absen->appends($request->only(["limit", "keyword", "jurusan", "kelas", "tanggal"]));


    $hadir = absenM::from("absensi-digital.absen as ad")
      ->join("siswa.siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "H")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $izin = absenM::from("absensi-digital.absen as ad")
      ->join("siswa.siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "I")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $sakit = absenM::from("absensi-digital.absen as ad")
      ->join("siswa.siswa as s", "s.nisn", "ad.nisn")
      ->where("ad.ket", "S")
      ->where("s.idinstansi", $idinstansi)
      ->where("ad.tanggal", $tanggal)->count();
    $alpa = absenM::from("absensi-digital.absen as ad")
      ->join("siswa.siswa as s", "s.nisn", "ad.nisn")
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
