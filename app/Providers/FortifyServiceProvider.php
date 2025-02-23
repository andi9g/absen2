<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {

    // 🔒 Rate limiter: 5 kali percobaan login per 5 menit
    RateLimiter::for('login', function (Request $request) {
      return Limit::perMinutes(5, 5)->by($request->username . $request->ip());
    });


    // 🔑 Validasi login dengan username & password (hashed)
    Fortify::authenticateUsing(function (Request $request) {
      // dd($request->all());

      $user = User::where('username', $request->username)->first();

      if ($user && Hash::check($request->password, $user->password)) {
        return $user;
      }

      throw ValidationException::withMessages([
        'username' => ['Username atau password salah.'],
      ]);
    });


    // Fortify::createUsersUsing(CreateNewUser::class);
    // Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    // Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    // Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

    // RateLimiter::for('login', function (Request $request) {
    //   return Limit::perMinutes(5, 5)->by($request->username . $request->ip());
    // });

    // RateLimiter::for('two-factor', function (Request $request) {
    //   return Limit::perMinute(5)->by($request->session()->get('login.id'));
    // });
  }
}
