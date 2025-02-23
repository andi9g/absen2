<?php

namespace App\Http\Controllers;

use App\Models\jurusanM;
use Illuminate\Http\Request;

class jurusanC extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $keyword = empty($request->keyword) ? '' : $request->keyword;
    $jurusan = jurusanM::where("idinstansi", $request->idinstansi)
      ->where(function ($query) use ($keyword) {
        $query->where("namajurusan", "like", "%$keyword%")
          ->orWhere("jurusan", "like", "$keyword%");
      })
      ->get();

    return view("pages.pengaturan.jurusan", [
      "jurusan" => $jurusan,
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
      'jurusan' => 'required',
      'namajurusan' => 'required',
    ]);
    try {
      $data = $request->all();
      jurusanM::create($data);
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\jurusanM  $jurusanM
   * @return \Illuminate\Http\Response
   */
  public function show(jurusanM $jurusanM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\jurusanM  $jurusanM
   * @return \Illuminate\Http\Response
   */
  public function edit(jurusanM $jurusanM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\jurusanM  $jurusanM
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, jurusanM $jurusanM, $idjurusan)
  {
    $request->validate([
      'jurusan' => 'required',
      'namajurusan' => 'required',
    ]);
    // try{
    $data = $request->only(["jurusan", "namajurusan"]);
    jurusanM::where("idjurusan", $idjurusan)->where("idinstansi", $request->idinstansi)->update($data);
    return redirect()->back()->with('success', 'Success');
    // }catch(\Throwable $th){
    //     return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    // }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\jurusanM  $jurusanM
   * @return \Illuminate\Http\Response
   */
  public function destroy(jurusanM $jurusanM, Request $request, $idjurusan)
  {
    try {
      jurusanM::where("idinstansi", $request->idinstansi)->where("idjurusan", $idjurusan)->delete();
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }
}
