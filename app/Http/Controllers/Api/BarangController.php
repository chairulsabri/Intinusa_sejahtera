<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Get all barang.
     */
    public function index()
    {
        $barangs = Barang::all();
        return response()->json([
            'success' => true,
            'data' => $barangs
        ]);
    }

    /**
     * Store new barang.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Smartphone,Notebook,Keyboard,Mouse,Hardisk',
            'harga' => 'required|numeric|min:0',
            'tanggal_pembelian' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $barang = Barang::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Barang successfully created',
            'data' => $barang
        ], 201);
    }

    /**
     * Get specific barang.
     */
    public function show(Barang $barang)
    {
        return response()->json([
            'success' => true,
            'data' => $barang
        ]);
    }

    /**
     * Update barang.
     */
    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|in:Smartphone,Notebook,Keyboard,Mouse,Hardisk',
            'harga' => 'sometimes|required|numeric|min:0',
            'tanggal_pembelian' => 'sometimes|required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $barang->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Barang successfully updated',
            'data' => $barang
        ]);
    }

    /**
     * Delete barang.
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang successfully deleted'
        ]);
    }

    /**
     * Get dashboard stats (Total price per category).
     */
    public function dashboardStats()
    {
        $stats = Barang::select('kategori', DB::raw('SUM(harga) as total_harga'))
            ->groupBy('kategori')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
