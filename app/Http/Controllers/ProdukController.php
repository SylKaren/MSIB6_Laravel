<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\JenisProduk;
use DB;
use RealRashid\SweetAlert\Facades\Alert;


class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produk = Produk::join('jenis_produk', 'jenis_produk_id','=', 'jenis_produk.id')
        ->select ('produk.*', 'jenis_produk.nama as jenis')
        ->get();
        return view ('admin.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $jenis_produk = DB::table('jenis_produk')->get();
        return view ('admin.produk.create', compact('jenis_produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:produk|max:10',
            'nama' => 'required|max:45',
            'harga_jual' =>'required|numeric',
            'harga_beli' =>'required|numeric',
            'stok' =>'required|numeric',
            'min_stok' =>'required|numeric',
            'foto' =>'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'kode.max'  => 'Kode maksimal 10 karakter',
            'kode.required' => 'Kode wajib diisi',
            'kode.unique' => 'Kode tidak boleh sama',
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 45 karakter',
            'harga_jual.required' => 'Harga jual wajib diisi',
            'harga_jual.numeric' => 'Harga jual harus angka',
            'harga_beli.required' => 'Harga beli wajib diisi',
            'harga_beli.numeric' => 'Harga beli harus angka',
            'stok.required' => 'Stok wajib diisi',
            'stok.numeric' => 'Stok harus angka',
            'min_stok.required' => 'Min stok wajib diisi',
            'min_stok.numeric' => 'Min stok harus angka',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa jpg,jpeg,png',
            'foto.max' => 'Foto maksimal 2MB',
        ]
    );
        //proses upload foto
        if(!empty($request->foto)){
            $filename = 'foto-'.uniqid().'.'.$request->foto->extension();
            $request->foto->move(public_path('admin/image'), $filename);
        }else {
            $filename = '';
        }
        //tambah data produk
        DB::table('produk')->insert([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'harga_jual'=>$request->harga_jual,
            'harga_beli'=>$request->harga_beli,
            'stok'=>$request->stok,
            'min_stok'=>$request->min_stok,
            'deskripsi'=>$request->deskripsi,
            'foto'=>$filename,
            'jenis_produk_id'=>$request->jenis_produk_id,
        ]);
        // Alert::success('Tambah Produk', 'Berhasil Tambah Produk');
        return redirect('admin/produk')->with('success', 'Berhasil Menambahkan Produk');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $produk = Produk::join('jenis_produk', 'jenis_produk_id','=', 'jenis_produk.id')
        ->select ('produk.*', 'jenis_produk.nama as jenis')
        ->where('produk.id', $id)
        ->get();
        return view ('admin.produk.detail', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //jenis produk
        $jenis_produk = DB::table('jenis_produk')->get();
        //produk
        $produk = DB::table('produk')->where('id',$id)->get();
        return view ('admin.produk.edit', compact('jenis_produk', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //foto lama
        $fotolama = DB::table('produk')->select('foto')->where('id',$id)->get();
        foreach ($fotolama as $f1){
            $fotolama = $f1->foto;
        }
        //jika foto sudah ada yang terupload
        if(!empty($request->foto)){
            if(!empty($fotolama->foto))
            unlink(public_path('admin/image/' .$fotolama));
            $filename = 'foto-'.$request->id.'.'.$request->foto->extension();
            $request->foto->move(public_path('admin/image'), $filename);
            
        }else {
            $filename = $fotolama;
        }
        //update data produk
        DB::table('produk')->where('id',$id)->update([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'harga_jual'=>$request->harga_jual,
            'harga_beli'=>$request->harga_beli,
           'stok'=>$request->stok,
           'min_stok'=>$request->min_stok,
            'deskripsi'=>$request->deskripsi,
            'foto'=>$filename,
            'jenis_produk_id'=>$request->jenis_produk_id,
        ]);
        return redirect('admin/produk');
        DB::table('produk')->where('id',$id)->update([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'harga_jual'=>$request->harga_jual,
            'harga_beli'=>$request->harga_beli,
            'stok'=>$request->stok,
            'min_stok'=>$request->min_stok,
            'deskripsi'=>$request->deskripsi,
            'foto'=>$filename,
            'jenis_produk_id'=>$request->jenis_produk_id,
        ]);
        Alert::success('Update Produk', 'Berhasil Update Produk');
        return redirect('admin/produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        DB::table('produk')->where('id',$id)->delete();
        return redirect('admin/produk');
    }
}
