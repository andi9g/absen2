<?php

namespace App\Http\Controllers;

use App\Models\instansiM;
use Illuminate\Http\Request;

class instansiC extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $instansi = instansiM::where("idinstansi", $request->idinstansi)->first();

    return view("pages.pengaturan.instansi", [
      "instansi" => $instansi,
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
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\instansiM  $instansiM
   * @return \Illuminate\Http\Response
   */
  public function show(instansiM $instansiM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\instansiM  $instansiM
   * @return \Illuminate\Http\Response
   */
  public function edit(instansiM $instansiM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\instansiM  $instansiM
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, instansiM $instansiM, $idinstansi)
  {
    $request->validate([
      'namainstansi' => 'required',
    ]);

    try {
      $data = $request->only(["namainstansi"]);
      instansiM::where("idinstansi", $request->idinstansi)->update($data);
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\instansiM  $instansiM
   * @return \Illuminate\Http\Response
   */
  public function destroy(instansiM $instansiM)
  {
    //
  }
}
