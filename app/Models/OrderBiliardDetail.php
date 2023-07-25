<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBiliardDetail extends Model
{
    use HasFactory;

    protected $table='orderbiliarddetail';
    protected $primaryKey='id_order_biliard_detail';
    protected $guarded=[];

    public function paket()
    {
        return $this->hasOne(PaketBiliard::class, 'id_paket_biliard', 'id_paket_biliard');
    }

    public function order()
    {
        return $this->hasOne(OrderBiliard::class, 'id_order_biliard', 'id_order_biliard');
    }
}
