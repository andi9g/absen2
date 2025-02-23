<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jurusanM extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'idjurusan';
    protected $connection = 'mysql2';
    protected $fillable = ["idinstansi", "jurusan", "namajurusan"];
    protected $guard = [];

    public function siswa()
    {
        return $this->hasOne(siswaM::class, 'idjurusan','idjurusan');
    }

}
