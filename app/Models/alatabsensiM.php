<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alatabsensiM extends Model
{
    use HasFactory;
    protected $table = 'alatabsensi';
    protected $primaryKey = 'idalatabsensi';
    protected $connection = 'mysql';
    protected $fillable = ["idinstansi", "fungsi", "kodealat", "timestamp", "pascode"];

    public function instansi()
    {
        return $this->hasOne(instansiM::class, 'idinstansi','idinstansi');
    }
}
