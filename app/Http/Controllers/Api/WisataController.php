<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wisata; // Import model Wisata
use App\Http\Requests\StoreWisataRequest; // Import request validation for store
use Illuminate\Support\Facades\Storage; // Import Storage facade

class WisataController extends Controller
{
    /**
     * Mengambil jumlah total data wisata.
     */
    public function getWisataCount()
    {
        $count = Wisata::count();
        return response()->json(['count' => $count]);
    }

    /**
     * Menampilkan daftar sumber daya wisata.
     */
    public function index()
    {
        $keyword = request('keyword'); // Ambil keyword dari query parameter
        $wisatas = Wisata::query();

        if ($keyword) {
            // Cari berdasarkan 'nama' atau 'kategori' atau 'alamat'
            $wisatas->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('kategori', 'like', '%' . $keyword . '%')
                    ->orWhere('alamat', 'like', '%' . $keyword . '%');
        }

        $data = $wisatas->get()->map(function($wisata) {
            return [
                "id" => (string) $wisata->id,
                "nama" => $wisata->nama,
                "kategori" => $wisata->kategori ?? "",
                "deskripsi" => $wisata->deskripsi ?? "",
                "image" => $wisata->image ?? "", // Mengembalikan nama file gambar
                "alamat" => $wisata->alamat ?? "",
                "website" => $wisata->website ?? "",
                "no_telp" => $wisata->no_telp ?? "",
                "latitude" => $wisata->latitude ?? "",
                "longitude" => $wisata->longitude ?? "",
                "prioritas" => (string) $wisata->prioritas,
                "checkout" => (string) $wisata->checkout,
                "jam_buka" => $wisata->jam_buka ?? "",
                "jam_tutup" => $wisata->jam_tutup ?? "",
                "child_price" => (string) $wisata->child_price,
                "adult_price" => (string) $wisata->adult_price,
                "kuota" => (string) $wisata->kuota,
                "created_at" => $wisata->created_at ? $wisata->created_at->toDateTimeString() : null,
                "updated_at" => $wisata->updated_at ? $wisata->updated_at->toDateTimeString() : null,
                "deleted_at" => $wisata->deleted_at ? $wisata->deleted_at->toDateTimeString() : null,
            ];
        });

        $message = $keyword ? "Menampilkan semua data wisata dengan kata kunci {$keyword}" : "Menampilkan semua data wisata";

        return response()->json([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);
    }

    /**
     * Menyimpan sumber daya wisata yang baru dibuat di penyimpanan.
     * Menggunakan StoreWisataRequest untuk validasi.
     */
    public function store(StoreWisataRequest $request)
    {
        $validatedData = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('wisata_images','public'); // Simpan di storage/app/public/wisata_images
            $validatedData['image'] = basename($imagePath); // Simpan hanya nama file ke database
        } else {
            $validatedData['image'] = null; // Jika tidak ada gambar, set null
        }

        $wisata = Wisata::create($validatedData);

        return response()->json([
            "status" => true,
            "message" => "Data Wisata berhasil dibuat",
            "data" => [
                "id" => (string) $wisata->id,
                "nama" => $wisata->nama,
                "kategori" => $wisata->kategori ?? "",
                "deskripsi" => $wisata->deskripsi ?? "",
                "image" => $wisata->image ?? "",
                "alamat" => $wisata->alamat ?? "",
                "website" => $wisata->website ?? "",
                "no_telp" => $wisata->no_telp ?? "",
                "latitude" => $wisata->latitude ?? "",
                "longitude" => $wisata->longitude ?? "",
                "prioritas" => (string) $wisata->prioritas,
                "checkout" => (string) $wisata->checkout,
                "jam_buka" => $wisata->jam_buka ?? "",
                "kuota" => (string) $wisata->kuota,
                "jam_tutup" => $wisata->jam_tutup ?? "",
                "child_price" => (string) $wisata->child_price,
                "adult_price" => (string) $wisata->adult_price,
                "created_at" => $wisata->created_at ? $wisata->created_at->toDateTimeString() : null,
                "updated_at" => $wisata->updated_at ? $wisata->updated_at->toDateTimeString() : null,
                "deleted_at" => $wisata->deleted_at ? $wisata->deleted_at->toDateTimeString() : null,
            ]
        ], 201); // 201 Created
    }

    /**
     * Menampilkan sumber daya wisata yang ditentukan.
     */
    public function show($id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                "status" => false,
                "message" => "Data Wisata tidak ditemukan",
                "data" => null
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail data wisata berdasarkan id $id",
            "data" => [
                "id" => (string) $wisata->id,
                "nama" => $wisata->nama,
                "kategori" => $wisata->kategori ?? "",
                "deskripsi" => $wisata->deskripsi ?? "",
                "image" => $wisata->image ?? "",
                "alamat" => $wisata->alamat ?? "",
                "website" => $wisata->website ?? "",
                "no_telp" => $wisata->no_telp ?? "",
                "latitude" => $wisata->latitude ?? "",
                "longitude" => $wisata->longitude ?? "",
                "prioritas" => (string) $wisata->prioritas,
                "checkout" => (string) $wisata->checkout,
                "jam_buka" => $wisata->jam_buka ?? "",
                "jam_tutup" => $wisata->jam_tutup ?? "",
                "kuota" => (string) $wisata->kuota,
                "child_price" => (string) $wisata->child_price,
                "adult_price" => (string) $wisata->adult_price,
                "created_at" => $wisata->created_at ? $wisata->created_at->toDateTimeString() : null,
                "updated_at" => $wisata->updated_at ? $wisata->updated_at->toDateTimeString() : null,
                "deleted_at" => $wisata->deleted_at ? $wisata->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }

    /**
     * Memperbarui sumber daya wisata yang ditentukan di penyimpanan.
     * Menggunakan Request langsung untuk validasi, karena image bisa nullable.
     */
    public function update(Request $request, $id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                "status" => false,
                "message" => "Data Wisata tidak ditemukan",
                "data" => null
            ], 404);
        }

        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar opsional saat update
            'alamat' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'prioritas' => 'nullable|integer',
            'checkout' => 'nullable|boolean',
            'jam_buka' => 'nullable|string|max:255',
            'jam_tutup' => 'nullable|string|max:255',
            'child_price' => 'nullable|numeric',
            'adult_price' => 'nullable|numeric',
        ]);

        $dataToUpdate = $request->except(['image']); // Ambil semua data kecuali image

        // Handle image update
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($wisata->image && Storage::exists('public/wisata_images/' . $wisata->image)) {
                Storage::delete('public/wisata_images/' . $wisata->image);
            }
            $imagePath = $request->file('image')->store('wisata_images','public');
            $dataToUpdate['image'] = basename($imagePath);
        }

        $wisata->update($dataToUpdate);

        return response()->json([
            "status" => true,
            "message" => "Data Wisata berhasil diperbarui",
            "data" => [
                "id" => (string) $wisata->id,
                "nama" => $wisata->nama,
                "kategori" => $wisata->kategori ?? "",
                "deskripsi" => $wisata->deskripsi ?? "",
                "image" => $wisata->image ?? "",
                "alamat" => $wisata->alamat ?? "",
                "website" => $wisata->website ?? "",
                "no_telp" => $wisata->no_telp ?? "",
                "latitude" => $wisata->latitude ?? "",
                "longitude" => $wisata->longitude ?? "",
                "prioritas" => (string) $wisata->prioritas,
                "checkout" => (string) $wisata->checkout,
                "jam_buka" => $wisata->jam_buka ?? "",
                "jam_tutup" => $wisata->jam_tutup ?? "",
                "child_price" => (string) $wisata->child_price,
                "adult_price" => (string) $wisata->adult_price,
                "created_at" => $wisata->created_at ? $wisata->created_at->toDateTimeString() : null,
                "updated_at" => $wisata->updated_at ? $wisata->updated_at->toDateTimeString() : null,
                "deleted_at" => $wisata->deleted_at ? $wisata->deleted_at->toDateTimeString() : null,
            ]
        ]);
    }

    /**
     * Menghapus sumber daya wisata yang ditentukan dari penyimpanan.
     */
    public function destroy($id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                "status" => false,
                "message" => "Data Wisata tidak ditemukan",
                "data" => null
            ], 404);
        }

        // Hapus gambar terkait jika ada
        if ($wisata->image && Storage::exists('public/wisata_images/' . $wisata->image)) {
            Storage::delete('public/wisata_images/' . $wisata->image);
        }

        $wisata->delete();

        return response()->json([
            "status" => true,
            "message" => "Data Wisata berhasil dihapus"
        ]);
    }
}
