<?php

namespace App\Http\Controllers;

use App\Models\alatabsensiM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class perangkatC extends Controller
{
  public function index(Request $request)
  {
    $keyword = empty($request->keyword) ? '' : $request->keyword;

    $pengelola = alatabsensiM::where("idinstansi", $request->idinstansi)
      ->where("fungsi", "pengelola")
      ->get();

    $absensi = alatabsensiM::where("idinstansi", $request->idinstansi)
      ->where("fungsi", "absensi")
      ->get();

    return view("pages.pengaturan.perangkat", [
      "pengelola" => $pengelola,
      "absensi" => $absensi,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    try {
      $data = $request->all();
      $data["kodealat"] = substr(Str::uuid()->toString(), 0, 5);
      $timestamp = strtotime(date("Y-m-d H:i:s"));
      $data["timestamp"] = $timestamp;
      $data["pascode"] = Hash::make($data["kodealat"] . $timestamp);

      alatabsensiM::create($data);
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\alatabsensiM  $alatabsensiM
   * @return \Illuminate\Http\Response
   */
  public function show(alatabsensiM $alatabsensiM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\alatabsensiM  $alatabsensiM
   * @return \Illuminate\Http\Response
   */
  public function edit(alatabsensiM $alatabsensiM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\alatabsensiM  $alatabsensiM
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, alatabsensiM $alatabsensiM)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\alatabsensiM  $alatabsensiM
   * @return \Illuminate\Http\Response
   */
  public function destroy(alatabsensiM $alatabsensiM, $idalatabensi, Request $request)
  {
    try {
      alatabsensiM::where("idinstansi", $request->idinstansi)->where("idalatabsensi", $idalatabensi)->delete();
      return redirect()->back()->with('warning', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }
}
