<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHapus extends Model
{
    use HasFactory;

    protected $table = 'log_hapus_barang';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
    
    public function pesanan()
    {
        return $this->hasOne(pesanan::class, 'Id_pesanan', 'id_pesanan');
    }
    public function menu()
    {
        return $this->hasOne(menu::class, 'Id_Menu', 'id_menu');
    }
}
