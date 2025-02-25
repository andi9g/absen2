<?php

namespace App\Livewire;

use App\Models\siswaM;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GetSiswa extends Component
{
  public $search = '';
  public $nisn = '';
  public $selectedSiswa = null;
  public $results = [];

  public function updatedSearch()
  {
    $this->searchSiswa(); // Memanggil fungsi pencarian saat properti search diperbarui
  }

  public function searchSiswa()
  {
    if (strlen($this->search) >= 3) {
      $idinstansi = Auth::user()->idinstansi;

      $this->results = siswaM::from("siswa.siswa as s")
        ->where('namasiswa', 'like', '%' . $this->search . '%')
        ->leftJoin("siswa.kelas as k", "k.idkelas", "s.idkelas")
        ->where("s.idinstansi", $idinstansi)
        ->whereNot("k.namakelas", "LULUS")
        ->orderBy('s.namasiswa', 'asc')
        ->limit(10)
        ->get();
    } else {
      $this->results = [];
    }
  }

  public function selectSiswa($id)
  {
    $siswa = siswaM::find($id);
    if ($siswa) {
      $this->selectedSiswa = $siswa;
      $this->search = $siswa->namasiswa;
      $this->nisn = sprintf("%010s", $siswa->nisn);
      $this->results = [];
    }
  }

  public function render()
  {
    return view('livewire.get-siswa');
  }


  public function cari() {}
}
