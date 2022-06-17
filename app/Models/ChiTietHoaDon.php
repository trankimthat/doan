<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_hoa_dons';

    protected $fillable = [
        'san_pham_id',
        'ten_san_pham',
        'so_luong',
        'don_gia',
        'is_cart',
        'id_ban',
        'hoa_don_id',
        'agent_id',
    ];
}
