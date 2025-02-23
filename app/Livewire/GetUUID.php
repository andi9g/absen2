<?php

namespace App\Livewire;

use App\Models\alatabsensiM;
use App\Models\bacakartuM;
use App\Models\kartupelajarM;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GetUUID extends Component
{
  public $kodealat, $value, $message;

  // Menangkap parameter saat komponen di-mount
  public function mount($kodealat)
  {
    $this->kodealat = $kodealat;
  }

  public function render()
  {
    return view('livewire.get-u-u-i-d');
  }


  public function procesScan()
  {
    $kodealat = $this->kodealat;
    $idinstansi = Auth::user()->idinstansi;

    $data = bacakartuM::where("idinstansi", $idinstansi)
      ->whereHas("alatabsensi", function ($query) {
        $query->where("fungsi", "pengelola");
      })
      ->where("kodealat", $kodealat);

    if ($data->count() == 1) {
      $uuid = $data->first()->uuid;
      $cek = kartupelajarM::where("uuid", $uuid)->count();
      if ($cek == 0) {
        $this->value = $uuid;
        $this->message = 1;
      } else {
        $this->value = "";
        $this->message = 2;
      }
    } else {
      $this->value = "";
      $this->message = 3;
    }
  }
}
