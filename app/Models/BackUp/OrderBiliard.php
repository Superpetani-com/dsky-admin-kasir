<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBiliard extends Model
{
    use HasFactory;

    protected $table='order_biliard';
    protected $primaryKey='id_order_biliard';
    protected $guarded=[];

    public function meja()
    {
        return $this->hasOne(MejaBiliard::class, 'id_meja_biliard', 'id_meja_biliard');
    }
}
