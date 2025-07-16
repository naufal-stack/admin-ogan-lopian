<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah; // Import model Sekolah
use App\Http\Requests\StoreSekolahRequest; // Import request validation

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword'); // Ambil keyword dari query parameter
        $level = $request->query('level'); // Ambil parameter level untuk jenjang

        $sekolahs = Sekolah::query();

        if ($keyword) {
            // Cari berdasarkan 'nama', 'alamat', 'desa', atau 'kecamatan'
            $sekolahs->where('nama', 'like', '%' . $keyword . '%')
                     ->orWhere('alamat', 'like', '%' . $keyword . '%')
                     ->orWhere('desa', 'like', '%' . $keyword . '%')
                     ->orWhere('kecamatan', 'like', '%' . $keyword . '%');
        }

        if ($level) {
            $sekolahs->where('jenjang', 'like', '%' . $level . '%'); // Filter berdasarkan jenjang
        }

        $data = $sekolahs->get()->map(function($sekolah) {
            return [
                "id" => (string) $sekolah->id,
                "npsn" => $sekolah->npsn,
                "nama" => $sekolah->nama,
                "alamat" => $sekolah->alamat ?? "",
                "desa" => $sekolah->desa ?? "",
                "kecamatan" => $sekolah->kecamatan ?? "",
                "jenjang" => $sekolah->jenjang ?? "",
                "lat" => $sekolah->lat ?? null,
                "lng" => $sekolah->lng ?? null,
                "created_at" => $sekolah->created_at ? $sekolah->created_at->toDateTimeString() : null,
                "updated_at" => $sekolah->updated_at ? $sekolah->updated_at->toDateTimeString() : null,
                "deleted_at" => $sekolah->deleted_at ? $sekolah->deleted_at->toDateTimeString() : null,
            ];
        });

        $message = "Menampilkan semua data sekolah";
        if ($keyword) {
            $message .= " dengan kata kunci {$keyword}";
        }
        if ($level) {
            $message .= ($keyword ? " dan" : "") . " jenjang {$level}";
        }

        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSekolahRequest $request)
    {
        $sekolah = Sekolah::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Data Sekolah berhasil dibuat",
            "data" => [
                "id" => (string) $sekolah->id,
                "npsn" => $sekolah->npsn,
                "nama" => $sekolah->nama,
                "alamat" => $sekolah->alamat ?? "",
                "desa" => $sekolah->desa ?? "",
                "kecamatan" => $sekolah->kecamatan ?? "",
                "jenjang" => $sekolah->jenjang ?? "",
                "lat" => $sekolah->lat ?? null,
                "lng" => $sekolah->lng ?? null,
                "created_at" => $sekolah->created_at ? $sekolah->created_at->toDateTimeString() : null,
                "updated_at" => $sekolah->updated_at ? $sekolah->updated_at->toDateTimeString() : null,
                "deleted_at" => $sekolah->deleted_at ? $sekolah->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sekolah = Sekolah::find($id);

        if (!$sekolah) {
            return response()->json([
                "status" => false,
                "message" => "Data Sekolah tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data sekolah berdasarkan id $id",
            "data" => [
                "id" => (string) $sekolah->id,
                "npsn" => $sekolah->npsn,
                "nama" => $sekolah->nama,
                "alamat" => $sekolah->alamat ?? "",
                "desa" => $sekolah->desa ?? "",
                "kecamatan" => $sekolah->kecamatan ?? "",
                "jenjang" => $sekolah->jenjang ?? "",
                "lat" => $sekolah->lat ?? null,
                "lng" => $sekolah->lng ?? null,
                "created_at" => $sekolah->created_at ? $sekolah->created_at->toDateTimeString() : null,
                "updated_at" => $sekolah->updated_at ? $sekolah->updated_at->toDateTimeString() : null,
                "deleted_at" => $sekolah->deleted_at ? $sekolah->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }
    public function getSekolahCount()
    {
        $count = Sekolah::count();
        return response()->json(['count' => $count]);
    }
}
