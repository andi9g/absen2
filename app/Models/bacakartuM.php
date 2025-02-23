<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bacakartuM extends Model
{
  use HasFactory;
  protected $table = 'bacakartu';
  protected $primaryKey = 'idbacakartu';
  protected $connection = 'mysql';
  protected $guarded = [];

  public function instansi()
  {
    return $this->hasOne(instansiM::class, 'idinstansi', 'idinstansi');
  }
  public function alatabsensi()
  {
    return $this->hasOne(alatabsensiM::class, 'kodealat', 'kodealat');
  }
}
