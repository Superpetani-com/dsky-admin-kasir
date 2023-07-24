<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSensor extends Model
{
    use HasFactory;

    protected $table = 'log_sensor';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
