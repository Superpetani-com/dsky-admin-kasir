<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table='meja';
    protected $primaryKey='id_meja';
    protected $guarded=[];

    public function pesanan()
    {
        return $this->hasOne(pesanan::class, 'Id_pesanan', 'Id_pesanan');
    }

    public function pesanan_detail() {
        {
            return $this->hasMany(PesananDetail::class, 'id_pesanan', 'Id_pesanan');
        }
    }
}
