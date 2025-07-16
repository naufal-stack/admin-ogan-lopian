<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriLoker; // Import model KategoriLoker
use App\Models\Loker; // Import model Loker untuk menghitung total
use App\Http\Requests\StoreKategoriLokerRequest; // Import request validation

class KategoriLokerController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index()
    {
        $keyword = request('keyword'); // Ambil keyword dari query parameter
        $kategoriLokers = KategoriLoker::query();

        if ($keyword) {
            $kategoriLokers->where('name', 'like', '%' . $keyword . '%'); // Cari berdasarkan 'name' kategori
        }

        $data = $kategoriLokers->get()->map(function($kategori) {
            return [
                "id" => (string) $kategori->id,
                "name" => $kategori->name,
                "total" => (string) $kategori->lokers()->count(), // Hitung jumlah loker terkait
            ];
        });

        $message = $keyword ? "Menampilkan semua data kategori loker dengan kata kunci {$keyword}" : "Menampilkan semua data kategori loker";

        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Menyimpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(StoreKategoriLokerRequest $request)
    {
        $kategori = KategoriLoker::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Kategori Loker berhasil dibuat",
            "data" => [
                "id" => (string) $kategori->id,
                "name" => $kategori->name,
                "total" => "0", // Saat baru dibuat, total loker masih 0
            ]
        ], 201); // 201 Created
    }

    /**
     * Menampilkan sumber daya yang ditentukan.
     */
    public function show($id)
    {
        $kategori = KategoriLoker::find($id);

        if (!$kategori) {
            return response()->json([
                "status" => false,
                "message" => "Data kategori loker tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data kategori loker berdasarkan id $id",
            "data" => [
                "id" => (string) $kategori->id,
                "name" => $kategori->name,
                "total" => (string) $kategori->lokers()->count(), // Hitung jumlah loker terkait
            ]
        ]);
    }
}
