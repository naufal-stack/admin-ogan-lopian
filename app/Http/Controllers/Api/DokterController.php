<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokter; // Import model Dokter
use App\Http\Requests\StoreDokterRequest; // Import request validation

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword'); // Ambil keyword dari query parameter
        $keahlian = $request->query('keahlian'); // Ambil parameter keahlian

        $dokters = Dokter::query();

        if ($keyword) {
            // Cari berdasarkan 'nama', 'nomor_str', 'username', atau 'unit_kerja'
            $dokters->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('nomor_str', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%')
                    ->orWhere('unit_kerja', 'like', '%' . $keyword . '%');
        }

        if ($keahlian) {
            $dokters->where('keahlian', 'like', '%' . $keahlian . '%'); // Filter berdasarkan keahlian
        }

        $data = $dokters->get()->map(function($dokter) {
            return [
                "id" => (string) $dokter->id,
                "id_user" => $dokter->id_user ?? "",
                "nomor_str" => $dokter->nomor_str ?? "",
                "nama" => $dokter->nama,
                "username" => $dokter->username,
                // Password tidak ditampilkan untuk keamanan
                "keahlian" => $dokter->keahlian ?? "",
                "handphone" => $dokter->handphone ?? "",
                "unit_kerja" => $dokter->unit_kerja ?? "",
                "pengalaman" => (string) $dokter->pengalaman,
                "foto" => $dokter->foto ?? "", // Akan mengembalikan string Base64 utuh atau nama file
                "device_token" => $dokter->device_token ?? "",
                "created_at" => $dokter->created_at ? $dokter->created_at->toDateTimeString() : null,
                "updated_at" => $dokter->updated_at ? $dokter->updated_at->toDateTimeString() : null,
                "last_update" => $dokter->last_update ? $dokter->last_update->toDateTimeString() : null,
                "deleted_at" => $dokter->deleted_at ? $dokter->deleted_at->toDateTimeString() : null,
            ];
        });

        $message = "Menampilkan semua data dokter";
        if ($keyword) {
            $message .= " dengan kata kunci '{$keyword}'";
        }
        if ($keahlian) {
            $message .= ($keyword ? " dan" : "") . " keahlian '{$keahlian}'";
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
    public function store(StoreDokterRequest $request)
    {
        // Hash password sebelum menyimpan
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($validatedData['password']);

        $dokter = Dokter::create($validatedData);

        return response()->json([
            "status" => true,
            "message" => "Data Dokter berhasil dibuat",
            "data" => [
                "id" => (string) $dokter->id,
                "id_user" => $dokter->id_user ?? "",
                "nomor_str" => $dokter->nomor_str ?? "",
                "nama" => $dokter->nama,
                "username" => $dokter->username,
                // Password tidak ditampilkan untuk keamanan
                "keahlian" => $dokter->keahlian ?? "",
                "handphone" => $dokter->handphone ?? "",
                "unit_kerja" => $dokter->unit_kerja ?? "",
                "pengalaman" => (string) $dokter->pengalaman,
                "foto" => $dokter->foto ?? "",
                "device_token" => $dokter->device_token ?? "",
                "created_at" => $dokter->created_at ? $dokter->created_at->toDateTimeString() : null,
                "updated_at" => $dokter->updated_at ? $dokter->updated_at->toDateTimeString() : null,
                "last_update" => $dokter->last_update ? $dokter->last_update->toDateTimeString() : null,
                "deleted_at" => $dokter->deleted_at ? $dokter->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokter = Dokter::find($id);

        if (!$dokter) {
            return response()->json([
                "status" => false,
                "message" => "Data Dokter tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data dokter berdasarkan id $id",
            "data" => [
                "id" => (string) $dokter->id,
                "id_user" => $dokter->id_user ?? "",
                "nomor_str" => $dokter->nomor_str ?? "",
                "nama" => $dokter->nama,
                "username" => $dokter->username,
                // Password tidak ditampilkan untuk keamanan
                "keahlian" => $dokter->keahlian ?? "",
                "handphone" => $dokter->handphone ?? "",
                "unit_kerja" => $dokter->unit_kerja ?? "",
                "pengalaman" => (string) $dokter->pengalaman,
                "foto" => $dokter->foto ?? "",
                "device_token" => $dokter->device_token ?? "",
                "created_at" => $dokter->created_at ? $dokter->created_at->toDateTimeString() : null,
                "updated_at" => $dokter->updated_at ? $dokter->updated_at->toDateTimeString() : null,
                "last_update" => $dokter->last_update ? $dokter->last_update->toDateTimeString() : null,
                "deleted_at" => $dokter->deleted_at ? $dokter->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }

    public function getDokterCount()
    {
        $count = Dokter::count();
        return response()->json(['count' => $count]);
    }
}
