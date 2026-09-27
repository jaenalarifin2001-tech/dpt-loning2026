<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pemilih extends Model
{
    protected $table = 'pemilih';

    protected $fillable = [
        'nik', 'nkk', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'rt', 'rw', 'dusun', 'tps', 'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $hidden = ['nkk'];

    public function getNikTersensorAttribute(): string
    {
        return substr($this->nik, 0, 6) . str_repeat('*', 10);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }
}