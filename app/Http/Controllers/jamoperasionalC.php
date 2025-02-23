<?php

namespace App\Http\Controllers;

use App\Models\kelolawaktuM;
use Illuminate\Http\Request;

class jamoperasionalC extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $waktu = kelolawaktuM::where("idinstansi", $request->idinstansi)->first();

    return view("pages.pengaturan.jamoperasional", [
      "waktu" => $waktu,
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
      'jammasuk' => 'required',
      'jamkeluar' => 'required',
    ]);

    try {
      $data = $request->only(["jammasuk", "jamkeluar"]);
      $waktu = kelolawaktuM::where("idinstansi", $request->idinstansi);

      if ($waktu->count() === 0) {
        $data["idinstansi"] = $request->idinstansi;
        kelolawaktuM::create($data);
      } else {
        $waktu->first()->update($data);
      }
      return redirect()->back()->with('success', 'Success');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(kelolawaktuM $kelolawaktuM)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(kelolawaktuM $kelolawaktuM)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, kelolawaktuM $kelolawaktuM)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(kelolawaktuM $kelolawaktuM)
  {
    //
  }
}
