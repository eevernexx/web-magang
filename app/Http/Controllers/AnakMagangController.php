<?php

namespace App\Http\Controllers;

use App\Models\AnakMagang;
use Illuminate\Http\Request;

class AnakMagangController extends Controller
{
    public function index(Request $request)
    {
        $data = AnakMagang::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.anak_magangs.index', compact('data'));
    }

    public function create()
    {
        return view('pages.anak_magangs.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
        ]);

        AnakMagang::create($validatedData);

        return redirect()->route('anak_magangs.index')->with('success', 'Data berhasil disimpan.');

    }

    public function edit($id)
    {
        $item = AnakMagang::findOrFail($id);
        return view('pages.anak_magangs.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'asal_sekolah' => 'required|string|max:255',
            'bidang' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
        ]);


        AnakMagang::findOrFail($id)->update($validatedData);
        return redirect()->route('anak_magangs.index')->with('success', 'Data berhasil diperbaharui.');

    }

    public function destroy($id)
    {
        $item = AnakMagang::findOrFail($id);
        $item->delete();

        return redirect()->route('anak_magangs.index')->with('success', 'Data berhasil dihapus.');

    }
}
