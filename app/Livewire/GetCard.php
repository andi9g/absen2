<?php

namespace App\Livewire;

use App\Models\bacakartuM;
use App\Models\kartupelajarM;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GetCard extends Component
{

  public $kodealat;
  public $akses = 0;
  public $nama, $nisn, $rombel, $tempatlahir, $alamat;

  // Menangkap parameter saat komponen di-mount
  public function mount($kodealat)
  {
    $this->kodealat = $kodealat;
  }

  public function render()
  {
    return view('livewire.get-card');
  }

  public function getCard()
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
      $cek = kartupelajarM::where("uuid", $uuid);
      if ($cek->count() == 1) {
        $this->akses = 1;
        $this->nisn = $cek->first()->siswa->detailsiswa->nisn;
        $this->nama = $cek->first()->siswa->detailsiswa->nama;
        $this->tempatlahir = $cek->first()->siswa->detailsiswa->tempatlahir;
        $this->alamat = $cek->first()->siswa->detailsiswa->alamat;
        $this->rombel = $cek->first()->siswa->kelas->namakelas . " " . $cek->first()->siswa->jurusan->jurusan;
      } else {

        $this->akses = 2;
      }
    } else {
      $this->akses = 3;
    }
  }
}
