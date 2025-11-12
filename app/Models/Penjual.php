<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjual extends Model
{
     protected $fillable = ['user_id', 'nama_toko', 'alamat', 'kontak'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produks()
{
    return $this->hasMany(Produk::class, 'penjual_id');
}
}
