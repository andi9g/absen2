<?php

use App\Http\Controllers\absenC;
use App\Http\Controllers\akunInstansiC;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\emailC;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\MdiIcons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\homeSuperadminC;
use App\Http\Controllers\instansiC;
use App\Http\Controllers\jamoperasionalC;
use App\Http\Controllers\jurusanC;
use App\Http\Controllers\kartupelajarC;
use App\Http\Controllers\kelasC;
use App\Http\Controllers\perangkatC;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Middleware\getEmail;
use App\Http\Middleware\givedata;
use App\Http\Middleware\hakAdmin;
use App\Http\Middleware\hakAkses;
use App\Http\Middleware\hakSuperadmin;

Route::get('/login', [LoginBasic::class, 'index'])->name('login');
Route::get('/forgot-password', [LoginBasic::class, 'create'])->name('forgot.password');
Route::get('/reset-password/{token}', [LoginBasic::class, 'reset'])->name('password.reset');
Route::get("/", [absenC::class, "dataabsen"])->name("dataabsen");


Route::middleware(['auth', givedata::class])->group(function () {

  Route::resource('lengkapiemail', emailC::class);
  Route::post('/logout', [LoginBasic::class, 'logout'])->name('logout');

  Route::middleware([getEmail::class, hakAdmin::class])->group(function () {

    Route::get("absen", [absenC::class, "index"])->name("absen");
    Route::post("absen", [absenC::class, "store"])->name("absen.store");

    Route::get('/home', [Analytics::class, 'index'])->name('home');

    // layout
    Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
    Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
    Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
    Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
    Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

    //perangkat
    Route::resource("/perangkat", perangkatC::class)->names([
      "index" => "perangkat",
    ]);

    //jurusan
    Route::resource("jurusan", jurusanC::class)->names([
      'index' => 'jurusan'
    ]);

    //kelas
    Route::resource("kelas", kelasC::class)->names([
      'index' => 'kelas'
    ]);

    //instansi
    Route::resource("instansi", instansiC::class)->names([
      'index' => 'instansi'
    ]);;

    //jam operasional
    Route::resource('jamoperasional', jamoperasionalC::class)->names([
      'index' => 'jamoperasional'
    ]);


    //Registrasi Kartu
    Route::get("registrasikartu", [kartupelajarC::class, "index"])->name("registrasikartu");
    Route::post("registrasikartu/tambah", [kartupelajarC::class, "store"])->name("registrasikartu.store");
    Route::delete("registrasikartu/{nisn}/hapus", [kartupelajarC::class, "destroy"])->name("registrasikartu.destroy");

    //cek kartu
    Route::get("carikartu", [kartupelajarC::class, "carikartu"])->name("carikartu");

    // Route::post("/perangkat/store", [perangkatC::class, "store"])->name("perangkat.store");
    // Route::delete("/perangkat/{id}/destroy", [perangkatC::class, "destroy"])->name("perangkat.destroy");


    // pages
    Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
    Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
    Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
    Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
    Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
  });

  Route::middleware([hakSuperadmin::class])->group(function () {
    Route::get("dashboard", [homeSuperadminC::class, "index"])->name("dashboard");
    Route::resource('akun', akunInstansiC::class)->names(["index" => "akun"]);
  });
});
