<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\JenisProduk;
use App\Models\Kartu;
use App\Models\Pelanggan;
use DB;

class DashboardController extends Controller
{
    //
    public function index(){
        $produk = Produk::count();
        $jenis_produk = JenisProduk::count();
        $kartu = Kartu::count();
        $pelanggan = Pelanggan::count();
        $produkData = Produk::select('kode','harga_jual')->get();
        $jenis_kelamin = DB::table('pelanggan')
        ->selectRaw('jk, count(jk) as jumlah')
        ->groupBy('jk')
        ->get();
        return view('admin.dashboard', 
        compact('produk', 'jenis_produk', 'kartu', 'pelanggan', 'produkData', 'jenis_kelamin'));
    }
}
