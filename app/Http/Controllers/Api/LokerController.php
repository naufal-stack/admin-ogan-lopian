<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loker; // <-- PASTIKAN BARIS INI ADA!
use App\Http\Requests\StoreLokerRequest; // <-- PASTIKAN BARIS INI BENAR!

class LokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keyword = request('keyword'); // Ambil keyword dari query parameter
        $lokers = Loker::query();

        if ($keyword) {
            // Cari berdasarkan 'posisi' atau 'perusahaan'
            $lokers->where('posisi', 'like', '%' . $keyword . '%')
                   ->orWhere('perusahaan', 'like', '%' . $keyword . '%');
        }

        $data = $lokers->get()->map(function($loker) {
            return [
                "id" => (string) $loker->id,
                "id_user" => (string) $loker->id_user,
                "id_kategori" => (string) $loker->id_kategori,
                "posisi" => $loker->posisi,
                "deskripsi" => $loker->deskripsi ?? "",
                "perusahaan" => $loker->perusahaan,
                "logo" => $loker->logo ?? "", // Akan mengembalikan string Base64 utuh
                "pendidikan" => $loker->pendidikan ?? "",
                "lokasi" => $loker->lokasi ?? "",
                "tipe_pekerjaan" => $loker->tipe_pekerjaan ?? "",
                "level_pekerjaan" => $loker->level_pekerjaan ?? "",
                "kategori" => $loker->kategori ?? "",
                "website" => $loker->website ?? "",
                "salary_from" => (string) $loker->salary_from, // Pastikan bertipe string
                "salary_to" => (string) $loker->salary_to,     // Pastikan bertipe string
                "created_at" => $loker->created_at ? $loker->created_at->toDateTimeString() : null,
                "updated_at" => $loker->updated_at ? $loker->updated_at->toDateTimeString() : null,
                "deleted_at" => $loker->deleted_at ? $loker->deleted_at->toDateTimeString() : null,
            ];
        });

        $message = $keyword ? "Display all data by keyword {$keyword}" : "Display all data";

        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLokerRequest $request)
    {
        $loker = Loker::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Loker created successfully",
            "data" => [
                "id" => (string) $loker->id,
                "id_user" => (string) $loker->id_user,
                "id_kategori" => (string) $loker->id_kategori,
                "posisi" => $loker->posisi,
                "deskripsi" => $loker->deskripsi ?? "",
                "perusahaan" => $loker->perusahaan,
                "logo" => $loker->logo ?? "",
                "pendidikan" => $loker->pendidikan ?? "",
                "lokasi" => $loker->lokasi ?? "",
                "tipe_pekerjaan" => $loker->tipe_pekerjaan ?? "",
                "level_pekerjaan" => $loker->level_pekerjaan ?? "",
                "kategori" => $loker->kategori ?? "",
                "website" => $loker->website ?? "",
                "salary_from" => (string) $loker->salary_from,
                "salary_to" => (string) $loker->salary_to,
                "created_at" => $loker->created_at ? $loker->created_at->toDateTimeString() : null,
                "updated_at" => $loker->updated_at ? $loker->updated_at->toDateTimeString() : null,
                "deleted_at" => $loker->deleted_at ? $loker->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loker = Loker::find($id);

        if (!$loker) {
            return response()->json([
                "status" => false,
                "message" => "Data not found",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data by id $id",
            "data" => [
                "id" => (string) $loker->id,
                "id_user" => (string) $loker->id_user,
                "id_kategori" => (string) $loker->id_kategori,
                "posisi" => $loker->posisi,
                "deskripsi" => $loker->deskripsi ?? "",
                "perusahaan" => $loker->perusahaan,
                "logo" => $loker->logo ?? "",
                "pendidikan" => $loker->pendidikan ?? "",
                "lokasi" => $loker->lokasi ?? "",
                "tipe_pekerjaan" => $loker->tipe_pekerjaan ?? "",
                "level_pekerjaan" => $loker->level_pekerjaan ?? "",
                "kategori" => $loker->kategori ?? "",
                "website" => $loker->website ?? "",
                "salary_from" => (string) $loker->salary_from,
                "salary_to" => (string) $loker->salary_to,
                "created_at" => $loker->created_at ? $loker->created_at->toDateTimeString() : null,
                "updated_at" => $loker->updated_at ? $loker->updated_at->toDateTimeString() : null,
                "deleted_at" => $loker->deleted_at ? $loker->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }
    public function getLokerCount()
    {
        $count = Loker::count();
        return response()->json(['count' => $count]);
    }
}
