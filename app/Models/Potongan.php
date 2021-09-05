<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    protected $table = 'tbl_datapotongankaryawan';

    protected $fillable = ['id','idpegawai', 'idpotongan'];
}
