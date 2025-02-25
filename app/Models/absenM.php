<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absenM extends Model
{
  use HasFactory;
  protected $table = 'absen';
  protected $primaryKey = 'idabsen';
  protected $connection = 'mysql';
  protected $guarded = [];

  public function siswa()
  {
    return $this->belongsTo(siswaM::class, 'nisn', 'nisn')
      ->from("siswa.siswa");
  }
}
