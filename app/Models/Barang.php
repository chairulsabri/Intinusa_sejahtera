<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori',
        'harga',
        'tanggal_pembelian',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'harga' => 'decimal:2',
    ];
}
