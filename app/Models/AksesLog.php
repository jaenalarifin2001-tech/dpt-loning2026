<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesLog extends Model
{
    protected $table = 'akses_log';
    protected $fillable = ['nik_dicari', 'ip_address', 'user_agent', 'berhasil'];
}