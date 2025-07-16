<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel; // <-- PASTIKAN BARIS INI ADA!
use App\Http\Requests\StoreHotelRequest; // <-- PASTIKAN BARIS INI BENAR!

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $keyword = request('keyword'); // Ambil keyword dari query parameter
        $hotels = Hotel::query();

        if ($keyword) {
            $hotels->where('nama', 'like', '%' . $keyword . '%');
        }

        $data = $hotels->get()->map(function($hotel) {
            return [
                "id" => (string) $hotel->id, // Pastikan id bertipe string
                "nama" => $hotel->nama,
                "kategori" => $hotel->kategori,
                "deskripsi" => $hotel->deskripsi ?? "", // Jika null, tampilkan string kosong
                "image" => $hotel->image ?? "",
                "alamat" => $hotel->alamat,
                "website" => $hotel->website ?? "",
                "no_telp" => $hotel->no_telp ?? "",
                "latitude" => $hotel->latitude ?? "",
                "longitude" => $hotel->longitude ?? "",
                "jam_buka" => $hotel->jam_buka ?? "",
                "jam_tutup" => $hotel->jam_tutup ?? "",
            ];
        });

        // Contoh pesan berdasarkan keberadaan keyword
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
    public function store(StoreHotelRequest $request)
    {
        $hotel = Hotel::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Hotel created successfully",
            "data" => [
                "id" => (string) $hotel->id,
                "nama" => $hotel->nama,
                "kategori" => $hotel->kategori,
                "deskripsi" => $hotel->deskripsi ?? "",
                "image" => $hotel->image ?? "",
                "alamat" => $hotel->alamat,
                "website" => $hotel->website ?? "",
                "no_telp" => $hotel->no_telp ?? "",
                "latitude" => $hotel->latitude ?? "",
                "longitude" => $hotel->longitude ?? "",
                "jam_buka" => $hotel->jam_buka ?? "",
                "jam_tutup" => $hotel->jam_tutup ?? "",
            ]
        ], 201); // 201 Created
    }

    public function show($id)
{
    $hotel = Hotel::find($id);

    if (!$hotel) {
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
            "id" => (string) $hotel->id,
            "nama" => $hotel->nama,
            "kategori" => $hotel->kategori,
            "deskripsi" => $hotel->deskripsi ?? "",
            "image" => $hotel->image ?? "",
            "alamat" => $hotel->alamat,
            "website" => $hotel->website ?? "",
            "no_telp" => $hotel->no_telp ?? "",
            "latitude" => $hotel->latitude ?? "",
            "longitude" => $hotel->longitude ?? "",
            "jam_buka" => $hotel->jam_buka ?? "",
            "jam_tutup" => $hotel->jam_tutup ?? "",
        ]
    ]);
}

public function getHotelCount()
    {
        $count = Hotel::count();
        return response()->json(['count' => $count]);
    }
    // Anda bisa tambahkan method show, update, destroy di sini jika diperlukan
}
