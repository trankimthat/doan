<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XuatKho extends Model
{
    use HasFactory;
    protected $table = 'xuat_khos';

    protected $fillable = [
        'id_nguyen_lieu',
        'ten_nguyen_lieu',
        'so_luong',
        'type',
    ];
}
