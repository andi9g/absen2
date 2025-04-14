<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\passwordResetTokensM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function create()
  {
    return view('content.authentications.auth-forgot-password-basic');
  }
  public function reset(Request $request, $token)
  {
    return view('content.authentications.auth-reset-password', [
      "email" => $request->email,
      "token" => $token,
    ]);
  }

  public function store(Request $request)
  {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
      ? back()->with(['status' => __($status)])
      : back()->withErrors(['email' => __($status)]);
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return redirect('login')->with('success', 'Success');
  }
}
