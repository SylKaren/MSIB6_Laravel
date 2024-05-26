<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KartuController;
use App\Http\Controllers\PelangganController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('front.home');
});

//contoh routing untuk mengarahkan ke view, tanpa melalui controller
Route::get('/percobaan_pertama', function () {
    return view('hello');
});

//contoh routing yang mengarahkan ke dirinya sendiri, tanpa melalui controller
Route::get('/salam', function(){
    return "Selamat pagi peserta MSIB";
});

//contoh routing yang menggunakan parameter
Route::get('/staff/{nama}/{divisi}', function($nama, $divisi){
    return 'Nama Pegawai '.$nama.' <br>Departemen :'.$divisi; 
});

Route::get('/daftar_nilai', function () {
    //return view yang mengarahkan ke dalam view yang didalamnya ada folder nilai dan file daftar_nilai
    return view('nilai.daftar_nilai');
});

Route::get('/dashboard', function(){
    return view ('admin.dashboard');
});

//route memaggil controller setiap fungsi
Route::prefix('admin')->group(function(){
    //route controller memanggil setiap fungsi (nanti linknya menggunakan url, ada didalam view)
    Route::get('/jenis_produk', [JenisProdukController::class, 'index']);
    Route::post('/jenis_produk/store', [JenisProdukController::class, 'store']);
    Route::get('/kartu', [KartuController::class, 'index']);
    Route::post('/kartu/store', [KartuController::class, 'store']);

    //route dengan pemanggilan class
    Route::resource('produk', ProdukController::class);
    Route::resource('pelanggan', PelangganController::class);
});
