<?php

namespace App\Http\Controllers;

use App\Models\kelasM;
use Illuminate\Http\Request;

class kelasC extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $keyword = empty($request->keyword) ? '' : $request->keyword;
    $kelas = kelasM::where("idinstansi", $request->idinstansi)
      ->where(function ($query) use ($keyword) {
        $query->where("namakelas", "like", "%$keyword");
      })
      ->get();


    return view("pages.pengaturan.kelas", [
      "kelas" => $kelas,
      "keyword" => $keyword,
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
    $request->validate([
      'namakelas' => 'required',
    ]);
    try {
      $data = $request->all();
      kelasM::create($data);
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\kelasM  $kelasM
   * @return \Illuminate\Http\Response
   */
  public function show(kelasM $kelasM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\kelasM  $kelasM
   * @return \Illuminate\Http\Response
   */
  public function edit(kelasM $kelasM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\kelasM  $kelasM
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, kelasM $kelasM, $idkelas)
  {
    $request->validate([
      'namakelas' => 'required',
    ]);
    try {
      $data = $request->only(["namakelas"]);
      kelasM::where("idkelas", $idkelas)->where("idinstansi", $request->idinstansi)->first()->update($data);
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\kelasM  $kelasM
   * @return \Illuminate\Http\Response
   */
  public function destroy(kelasM $kelasM, Request $request, $idkelas)
  {
    try {
      kelasM::where("idinstansi", $request->idinstansi)->where("idkelas", $idkelas)->delete();
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }
}
