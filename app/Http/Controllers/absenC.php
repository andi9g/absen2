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
use Illuminate\Support\Facades\DB;

class absenC extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    $idinstansi = $request->idinstansi;

    $keyword = empty($request->keyword) ? '' : $request->keyword;
    $kelas = empty($request->kelas) ? '' : $request->kelas;
    $jurusan = empty($request->jurusan) ? '' : $request->jurusan;
    $tanggal = empty($request->tanggal) ? date("Y-m-d") : $request->tanggal;

    $siswa = [];
    if (!empty($keyword) || !empty($kelas) || !empty($jurusan)) {
      $siswa = siswaM::where("idinstansi", $idinstansi)
        ->whereHas("jurusan", function ($query) use ($jurusan) {
          $query->when($jurusan, fn($q) => $q->where('jurusan', $jurusan));
        })
        ->whereHas("detailsiswa", function ($query) use ($keyword) {
          $query->when($keyword, fn($q) => $q->where('nama', "like", "%$keyword%"));
        })
        ->whereHas("kelas", function ($query) use ($kelas) {
          $query->when($kelas, fn($q) => $q->where('namakelas', $kelas))
            ->whereNot("namakelas", "LULUS");
        })
        ->selectRaw("LPAD(nisn, 10, '0') as nisn")
        ->pluck("nisn")
        ->toArray();
    }

    // dd($siswa);


    $data_jurusan = jurusanM::where("idinstansi", $idinstansi)->get();
    $data_kelas = kelasM::where("idinstansi", $idinstansi)->get();

    $waktu = kelolawaktuM::where("idinstansi", $idinstansi)->first();

    $keterangan = keteranganM::get();

    $absen = absenM::when(!empty($siswa), function ($query) use ($siswa) {
      $query->whereIn("nisn", $siswa);
    })
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->orderBy("jammasuk", "asc")
      ->paginate(10);

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


    $hadir = absenM::where("ket", "H")
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)->count();
    $izin = absenM::where("ket", "I")
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)->count();
    $sakit = absenM::where("ket", "S")
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)->count();
    $alpa = absenM::where("ket", "A")
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)->count();

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

  public function dataabsen(Request $request)
  {

    $idinstansi = empty($request->idinstansi) ?? 1;

    $keyword = empty($request->keyword) ? '' : $request->keyword;
    $kelas = empty($request->kelas) ? '' : $request->kelas;
    $jurusan = empty($request->jurusan) ? '' : $request->jurusan;
    $tanggal = empty($request->tanggal) ? date("Y-m-d") : $request->tanggal;

    $siswa = [];
    if (!empty($keyword) || !empty($kelas) || !empty($jurusan)) {
      $siswa = siswaM::where("idinstansi", $idinstansi)
        ->whereHas("jurusan", function ($query) use ($jurusan) {
          $query->when($jurusan, fn($q) => $q->where('jurusan', $jurusan));
        })
        ->whereHas("detailsiswa", function ($query) use ($keyword) {
          $query->when($keyword, fn($q) => $q->where('nama', "like", "%$keyword%"));
        })
        ->whereHas("kelas", function ($query) use ($kelas) {
          $query->when($kelas, fn($q) => $q->where('namakelas', $kelas))
            ->whereNot("namakelas", "LULUS");
        })
        ->selectRaw("LPAD(nisn, 10, '0') as nisn")
        ->pluck("nisn")
        ->toArray();
    }

    // dd($siswa);


    $data_jurusan = jurusanM::where("idinstansi", $idinstansi)->get();
    $data_kelas = kelasM::where("idinstansi", $idinstansi)->whereNot("namakelas", "LULUS")->get();

    $waktu = kelolawaktuM::where("idinstansi", $idinstansi)->first();

    $keterangan = keteranganM::get();

    $absen = absenM::when(!empty($siswa), function ($query) use ($siswa) {
      $query->whereIn("nisn", $siswa);
    })
      ->where("idinstansi", $idinstansi)
      ->where("tanggal", $tanggal)
      ->orderBy("jammasuk", "asc")
      ->paginate(10);

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


    return view("pages.umum.absen", [
      "data_jurusan" => $data_jurusan,
      "data_kelas" => $data_kelas,
      "tanggal" => $tanggal,
      "jurusan" => $jurusan,
      "keyword" => $keyword,
      "absen" => $absen,
      "waktu" => $waktu,
      "kelas" => $kelas,
      "keterangan" => $keterangan
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
