<?php

namespace App\Http\Controllers;

use App\Models\alatabsensiM;
use App\Models\kartupelajarM;
use App\Models\siswaM;
use Illuminate\Http\Request;

class kartupelajarC extends Controller
{

  public function carikartu(Request $request)
  {
    $validasikode = empty($request->kodealat) ? 'none' : $request->kodealat;
    try {
      $kodealat = alatabsensiM::where("idinstansi", $request->idinstansi)
        ->where("fungsi", "pengelola")
        ->where("kodealat", $validasikode)
        ->select("kodealat")
        ->first()->kodealat;
    } catch (\Throwable $th) {
      // dd($th);
      $kodealat = "";
    }

    //perangkat
    $alatabsensi = alatabsensiM::where("idinstansi", $request->idinstansi)
      ->where("fungsi", "pengelola")
      ->select("kodealat")
      ->get();

    return view("pages.kartupelajar.carikartu", [
      "kodealat" => $kodealat,
      "alatabsensi" => $alatabsensi,
    ]);
  }

  public function index(Request $request)
  {
    $keyword = empty($request->keyword) ? '' : $request->keyword;

    $validasikode = empty($request->kodealat) ? 'none' : $request->kodealat;
    try {
      $kodealat = alatabsensiM::where("idinstansi", $request->idinstansi)
        ->where("fungsi", "pengelola")
        ->where("kodealat", $validasikode)
        ->select("kodealat")
        ->first()->kodealat;
    } catch (\Throwable $th) {
      // dd($th);
      $kodealat = "";
    }
    // dd($kodealat);

    //perangkat
    $alatabsensi = alatabsensiM::where("idinstansi", $request->idinstansi)
      ->where("fungsi", "pengelola")
      ->select("kodealat")
      ->get();

    $siswa = siswaM::where("idinstansi", $request->idinstansi)
      ->whereHas("kelas", function ($query) {
        $query->whereNotIn("namakelas", ["LULUS"]);
      })
      ->orderBy("idkelas", "asc")
      ->orderBy("idjurusan", "asc")
      ->whereHas("detailsiswa", function ($query) use ($keyword) {
        $query->where("nama", "like", "%$keyword%")
          ->orderBy("nama", "asc");
      })
      ->paginate(15);


    $siswa->appends($request->only(["limit", "keyword", "kodealat"]));


    return view("pages.kartupelajar.registrasikartu", [
      "siswa" => $siswa,
      "keyword" => $keyword,
      "alatabsensi" => $alatabsensi,
      "kodealat" => $kodealat,
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
      'uuid' => 'required',
    ]);

    try {
      $idinstansi = $request->idinstansi;
      $data = $request->only(["nisn", "uuid"]);
      $data["nisn"] = sprintf("%010s", $request->nisn);
      $data["ket"] = "siswa";

      $cek = siswaM::where("nisn", $data["nisn"])
        ->where("idinstansi", $idinstansi)
        ->count();

      if ($cek == 1) {
        kartupelajarM::create($data);
        return redirect()->back()->with('success', 'Success');
      }
      return redirect()->back()->with('error', 'Terjadi kesalahan');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(kartupelajarM $kartupelajarM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(kartupelajarM $kartupelajarM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, kartupelajarM $kartupelajarM)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(kartupelajarM $kartupelajarM, Request $request, $nisn)
  {
    try {
      $nisn = sprintf("%010s", $nisn);
      $idinstansi = $request->idinstansi;
      $cek = kartupelajarM::where("nisn", $nisn)
        ->whereHas("siswa", function ($query) use ($idinstansi) {
          $query->from("siswa")
            ->where("idinstansi", $idinstansi);
        })->count();

      // dd($cek);
      if ($cek == 1) {
        kartupelajarM::where("nisn", $nisn)->delete();
        return redirect()->back()->with('success', 'Success');
      } else {
        return redirect()->back()->with('error', 'Terjadi kesalahan');
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }
}
