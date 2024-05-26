<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProduk extends Model
{
    use HasFactory;
    //panggil table yang akan digunakan
    protected $table = 'jenis_produk';

    //panggil kolom yang ada di table (sesuai dengan ada yang di dalam table)
    protected $fillable = [
        'nama',
    ];

    //penanda atau pemanggilan class produk untuk relasi one to many
    public function produk(){
        return $this->hasMany(Produk::class);
    }
}
