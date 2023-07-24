<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;

    protected $table='pesanan_detail';
    protected $primaryKey='id_pesanan_detail';
    protected $guarded=[];

    public function menu()
    {
        return $this->hasOne(menu::class, 'Id_Menu', 'id_menu');
    }
}
