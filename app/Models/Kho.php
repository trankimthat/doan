<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kho extends Model
{
    use HasFactory;
    protected $table = 'khos';

    protected $fillable = [
        'id_nguyen_lieu',
        'ten_nguyen_lieu',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'type',

    ];
}
