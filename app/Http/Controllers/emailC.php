<?php

namespace App\Http\Controllers;

use App\Models\instansiM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class emailC extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    if (!empty(Auth::user()->email)) {
      return redirect('home');
    }
    $instansi = instansiM::take(1)->get();
    return view("pages.email", [
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
    $request->validate([
      'email' => 'required|email|unique:mysql3.user,email',
    ], [
      "email.unique" => 'Email telah digunakan!',
    ]);

    try {
      $email = $request->only(["email"]);

      Auth::user()->update($email);

      return redirect('home')->with('success', 'Welcome to SIPRESENSI');
    } catch (\Throwable $th) {
      return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
    }
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
