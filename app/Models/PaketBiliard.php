<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketBiliard extends Model
{
    use HasFactory;

    protected $table='paketbiliard';
    protected $primaryKey='id_paket_biliard';
    protected $guarded=[];
}
