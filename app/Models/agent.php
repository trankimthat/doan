<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agent extends Authenticatable
{
    use HasFactory;
    protected $table = 'agents';

    protected $fillable = [
        'ho_lot',
        'ten',
        'ho_va_ten',
        'so_dien_thoai',
        'email',
        'password',
        'dia_chi',
        'is_open',
    ];
}
