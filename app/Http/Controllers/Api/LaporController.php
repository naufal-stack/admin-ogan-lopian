<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lapor; // Import model Lapor
use App\Http\Requests\StoreLaporRequest; // Import request validation

class LaporController extends Controller
{
    /**
     * Menampilkan daftar sumber daya.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword'); // Ambil keyword dari query parameter
        $kategori = $request->query('kategori'); // Ambil parameter kategori

        $lapors = Lapor::query();

        if ($keyword) {
            // Cari berdasarkan 'judul', 'keterangan', atau 'author'
            $lapors->where('judul', 'like', '%' . $keyword . '%')
                   ->orWhere('keterangan', 'like', '%' . $keyword . '%')
                   ->orWhere('author', 'like', '%' . $keyword . '%');
        }

        if ($kategori) {
            $lapors->where('kategori', 'like', '%' . $kategori . '%'); // Filter berdasarkan kategori
        }

        $data = $lapors->get()->map(function($lapor) {
            return [
                "id" => (string) $lapor->id,
                "id_user" => $lapor->id_user ?? "",
                "author" => $lapor->author ?? "",
                "judul" => $lapor->judul,
                "keterangan" => $lapor->keterangan ?? "",
                "status_laporan" => $lapor->status_laporan ?? null,
                "lat" => $lapor->lat ?? null,
                "lng" => $lapor->lng ?? null,
                "report_time" => $lapor->report_time ? $lapor->report_time->toDateTimeString() : null,
                "kategori" => $lapor->kategori ?? "",
                "created_at" => $lapor->created_at ? $lapor->created_at->toDateTimeString() : null,
                "updated_at" => $lapor->updated_at ? $lapor->updated_at->toDateTimeString() : null,
                "deleted_at" => $lapor->deleted_at ? $lapor->deleted_at->toDateTimeString() : null,
            ];
        });

        $message = "Menampilkan semua data laporan";
        if ($keyword) {
            $message .= " dengan kata kunci '{$keyword}'";
        }
        if ($kategori) {
            $message .= ($keyword ? " dan" : "") . " kategori '{$kategori}'";
        }

        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Menyimpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(StoreLaporRequest $request)
    {
        $lapor = Lapor::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Laporan berhasil dibuat",
            "data" => [
                "id" => (string) $lapor->id,
                "id_user" => $lapor->id_user ?? "",
                "author" => $lapor->author ?? "",
                "judul" => $lapor->judul,
                "keterangan" => $lapor->keterangan ?? "",
                "status_laporan" => $lapor->status_laporan ?? null,
                "lat" => $lapor->lat ?? null,
                "lng" => $lapor->lng ?? null,
                "report_time" => $lapor->report_time ? $lapor->report_time->toDateTimeString() : null,
                "kategori" => $lapor->kategori ?? "",
                "created_at" => $lapor->created_at ? $lapor->created_at->toDateTimeString() : null,
                "updated_at" => $lapor->updated_at ? $lapor->updated_at->toDateTimeString() : null,
                "deleted_at" => $lapor->deleted_at ? $lapor->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    /**
     * Menampilkan sumber daya yang ditentukan.
     */
    public function show($id)
    {
        $lapor = Lapor::find($id);

        if (!$lapor) {
            return response()->json([
                "status" => false,
                "message" => "Data Laporan tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data laporan berdasarkan id $id",
            "data" => [
                "id" => (string) $lapor->id,
                "id_user" => $lapor->id_user ?? "",
                "author" => $lapor->author ?? "",
                "judul" => $lapor->judul,
                "keterangan" => $lapor->keterangan ?? "",
                "status_laporan" => $lapor->status_laporan ?? null,
                "lat" => $lapor->lat ?? null,
                "lng" => $lapor->lng ?? null,
                "report_time" => $lapor->report_time ? $lapor->report_time->toDateTimeString() : null,
                "kategori" => $lapor->kategori ?? "",
                "created_at" => $lapor->created_at ? $lapor->created_at->toDateTimeString() : null,
                "updated_at" => $lapor->updated_at ? $lapor->updated_at->toDateTimeString() : null,
                "deleted_at" => $lapor->deleted_at ? $lapor->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }
}
