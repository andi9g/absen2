<?php

namespace App\Http\Controllers;

use App\Models\instansiM;
use App\Models\User;
use Illuminate\Http\Request;

class akunInstansiC extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $keyword = empty($request->keyword) ? '' : $request->keyword;

    $instansi = instansiM::where(function ($query) use ($keyword) {
      $query->when($keyword, fn($q) => $q->where("namainstansi", "like", "%$keyword%"))
        ->when($keyword, fn($q) => $q->where("npsn", "like", "$keyword%"));
    })
      ->orderBy("namainstansi", "asc")
      ->paginate(15);

    return view("pages.email", [
      "keyword" => $keyword,
      "instansi" => $instansi,
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
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    //
  }
}
