<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MejaBiliard extends Model
{
    use HasFactory;

    protected $table='mejabiliard';
    protected $primaryKey='id_meja_biliard';
    protected $guarded=[];

    public function latestOrder()
{
    return $this->hasOne(OrderBiliard::class, 'id_order_biliard', 'id_order_biliard')->ofMany('id_order_biliard', 'max');;
}
    public function order()
    {
        return $this->hasOne(OrderBiliard::class, 'id_order_biliard', 'id_order_biliard');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderBiliardDetail::class, 'id_order_biliard', 'id_order_biliard');
    }
}
