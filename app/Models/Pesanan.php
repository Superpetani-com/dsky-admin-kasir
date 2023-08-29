<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table='pesanan';
    protected $primaryKey='Id_pesanan';
    protected $guarded=[];

    public function meja()
    {
        return $this->hasOne(meja::class, 'id_meja', 'Id_meja');
    }


    public function meja_biliard()
    {
        return $this->hasOne(mejabiliard::class, 'id_meja_biliard', 'Id_meja');
    }


    public function pesananDetail()
    {
        return $this->hasMany(pesananDetail::class, 'id_pesanan', 'Id_pesanan');
    }
}
