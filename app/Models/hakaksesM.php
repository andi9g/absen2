<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hakaksesM extends Model
{
  use HasFactory;
  protected $table = 'hakakses';
  protected $primaryKey = 'idhakakses';
  protected $connection = 'mysql3';
  protected $guarded = [];

  public function user()
  {
    return $this->belongsTo(User::class, 'iduser', 'iduser');
  }
}
