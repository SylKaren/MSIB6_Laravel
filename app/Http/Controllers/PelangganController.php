<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kartu;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pelanggan = Pelanggan::all();
        return view ('admin.pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $kartu = Kartu::all();
        $gender = ['L', 'P'];
        return view ('admin.pelanggan.create', compact('kartu', 'gender'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!empty($request->foto)){
            $filename = 'foto-'.uniqid().'.'.$request->foto->extension();
            $request->foto->move(public_path('admin/image'), $filename);
        }else {
            $filename = '';
        }
        //tambah data menggunakan eluquent
        $pelanggan = new Pelanggan;
        $pelanggan->kode = $request->kode;
        $pelanggan->nama = $request->nama;
        $pelanggan->jk = $request->jk;
        $pelanggan->tmp_lahir = $request->tmp_lahir;
        $pelanggan->tgl_lahir = $request->tgl_lahir;
        $pelanggan->email = $request->email;
        $pelanggan->foto = $filename;
        $pelanggan->kartu_id = $request->kartu_id;
        $pelanggan->save();
        return redirect('admin/pelanggan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //show eloquent
        $pelanggan = Pelanggan::find($id);
        return view ('admin.pelanggan.detail', compact('pelanggan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $pl = Pelanggan::find($id);
        $kartu = Kartu::all();
        $gender = ['L', 'P'];
        return view ('admin.pelanggan.edit', compact('pl', 'kartu', 'gender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //foto lama
        $fotolama = Pelanggan::select('foto')->where('id', $id)->get();
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
        //tambah data menggunakan eluquent
        $pelanggan = Pelanggan::find($id);
        $pelanggan->kode = $request->kode;
        $pelanggan->nama = $request->nama;
        $pelanggan->jk = $request->jk;
        $pelanggan->tmp_lahir = $request->tmp_lahir;
        $pelanggan->tgl_lahir = $request->tgl_lahir;
        $pelanggan->email = $request->email;
        $pelanggan->foto = $filename;
        $pelanggan->kartu_id = $request->kartu_id;
        $pelanggan->save();
        return redirect('admin/pelanggan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $pelanggan = Pelanggan::find($id);
        $pelanggan->delete();
        return redirect('admin/pelanggan');
    }
}
