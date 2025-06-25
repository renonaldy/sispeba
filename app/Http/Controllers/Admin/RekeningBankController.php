<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningBank;
use Illuminate\Http\Request;

class RekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = RekeningBank::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_bank', 'like', '%' . $request->search . '%')
                ->orWhere('nomor_rekening', 'like', '%' . $request->search . '%')
                ->orWhere('atas_nama', 'like', '%' . $request->search . '%')
                ->orWhere('jenis', 'like', '%' . $request->search . '%');
        }

        $rekening = $query->orderBy('id', 'asc')->paginate(10);
        return view('admin.rekening.index', compact('rekening'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.rekening.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_bank' => 'required',
            'nomor_rekening' => 'required',
            'atas_nama' => 'required',
            'jenis' => 'required|in:bank,e-wallet',
        ]);

        RekeningBank::create($request->all());
        return redirect()->route('admin.rekening.index')->with('success', 'Rekening ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $rekening = RekeningBank::findOrFail($id);
        return view('admin.rekening.edit', compact('rekening'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $rekening = RekeningBank::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nomor_rekening' => 'required',
            'atas_nama' => 'required',
            'jenis' => 'required|in:bank,e-wallet',
        ]);

        $rekening->update($request->all());

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RekeningBank $rekening)
    {
        //
        $rekening->delete();
        return back()->with('success', 'Rekening dihapus.');
    }
}
