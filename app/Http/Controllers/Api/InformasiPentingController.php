<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InformasiPenting; // <-- PASTIKAN BARIS INI ADA!
use App\Http\Requests\StoreInfoRequest; // <-- PASTIKAN BARIS INI BENAR!

class InformasiPentingController extends Controller
{


    public function index()
    {
        $keyword = request('keyword'); // Ambil keyword dari query parameter
        $info = InformasiPenting::query();

        if ($keyword) {
            $info->where('name', 'like', '%' . $keyword . '%'); // Cari berdasarkan 'name'
        }

        $data = $info->get()->map(function($item) {
            return [
                "id" => (string) $item->id,
                "id_user" => (string) $item->id_user, // Pastikan id_user bertipe string
                "name" => $item->name,
                "content" => $item->content ?? "",
                "image" => $item->image ?? "",
                "created_at" => $item->created_at ? $item->created_at->toDateTimeString() : null, // Format datetime
                "updated_at" => $item->updated_at ? $item->updated_at->toDateTimeString() : null,
                "deleted_at" => $item->deleted_at ? $item->deleted_at->toDateTimeString() : null,
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
    public function store(StoreInfoRequest $request)
    {
        $info = InformasiPenting::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Informasi Penting created successfully",
            "data" => [
                "id" => (string) $info->id,
                "id_user" => (string) $info->id_user,
                "name" => $info->name,
                "content" => $info->content ?? "",
                "image" => $info->image ?? "",
                "created_at" => $info->created_at ? $info->created_at->toDateTimeString() : null,
                "updated_at" => $info->updated_at ? $info->updated_at->toDateTimeString() : null,
                "deleted_at" => $info->deleted_at ? $info->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    public function show($id){
        $item = InformasiPenting::find($id);

        if (!$item) {
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
                "id" => (string) $item->id,
                "id_user" => (string) $item->id_user,
                "name" => $item->name,
                "content" => $item->content ?? "",
                "image" => $item->image ?? "",
                "created_at" => $item->created_at ? $item->created_at->toDateTimeString() : null,
                "updated_at" => $item->updated_at ? $item->updated_at->toDateTimeString() : null,
                "deleted_at" => $item->deleted_at ? $item->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }

    public function getInfoCount()
    {
        $count = InformasiPenting::count();
        return response()->json(['count' => $count]);
    }

}
