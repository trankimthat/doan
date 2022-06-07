<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kho extends Model
{
    use HasFactory;
    protected $table = 'khos';

    protected $fillable = [
        'id_danh_muc',
        'ten_danh_muc',
        'so_luong',
        'don_gia',
        'thanh_tien',
        'type',

    ];
}
