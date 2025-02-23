<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instansiM extends Model
{
    use HasFactory;
    protected $table = 'instansi';
    protected $primaryKey = 'idinstansi';
    protected $connection = 'mysql4';
    protected $fillable = ["namainstansi"];

    public function user()
    {
        return $this->belongsTo(User::class, 'idinstansi','idinstansi');
    }

    public function alatabsensi()
    {
        return $this->belongsTo(alatabsensiM::class, 'idinstansi','idinstansi');
    }
    public function siswa()
    {
        return $this->belongsTo(siswaM::class, 'idinstansi','idinstansi');
    }
}
