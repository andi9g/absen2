<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
      public function toResponse($request)
      {
        return redirect('/login');
      }
    });
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {



    RateLimiter::for('login', function (Request $request) {
      return Limit::perMinute(5)->by($request->username . $request->ip());
    });

    Fortify::loginView(function () {
      return view('content.authentications.auth-login-basic');
    });


    Fortify::authenticateUsing(function (Request $request) {
      $user = User::where('email', $request->username)->orWhere('username', $request->username)->first();

      if (
        $user &&
        Hash::check($request->password, $user->password)
      ) {
        return $user;
      }
    });

    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
    Fortify::redirects('password-reset', function () {
      Auth::logout(); // Paksa logout setelah reset password
      return redirect('login')->with("success", "Silahkan Login");
    });

    Fortify::resetPasswordView(function (Request $request) {
      return view('content.authentications.auth-login-basic', ['request' => $request]);
    });


    Fortify::requestPasswordResetLinkView(function () {
      return view('content.authentications.auth-waiting');
    });
  }
}
