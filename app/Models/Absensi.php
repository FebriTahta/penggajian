<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'tbl_absensi';

    protected $fillable = ['id','idpegawai', 'tanggal','jam_hadir','jam_pulang'];
}
