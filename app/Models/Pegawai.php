<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'tbl_pegawai';

    protected $fillable = ['id','idjabatan', 'nama','tgl', 'ttl', 'alamat','telp'];
}
