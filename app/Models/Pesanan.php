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
}
