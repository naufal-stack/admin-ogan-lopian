<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Register; // Import model Register
use App\Http\Requests\StoreRegisterRequest; // Import request validation
use Illuminate\Support\Str; // Untuk menghasilkan string acak (activation_key)
use Illuminate\Support\Facades\Mail; // Import Mail Facade
use App\Mail\ActivationMail; // Import Mailable class

class RegisterController extends Controller
{
    /**
     * Menyimpan sumber daya yang baru dibuat di penyimpanan.
     */
    public function store(StoreRegisterRequest $request)
    {
        $validatedData = $request->validated();

        // Hash password sebelum menyimpan
        $validatedData['password'] = bcrypt($validatedData['password']);
        // Hasilkan kunci aktivasi acak
        $validatedData['activation_key'] = Str::random(32); // Contoh: 32 karakter acak

        $register = Register::create($validatedData);

        // Buat link aktivasi
        $activationLink = url('/account?activation=' . $register->activation_key);

        // Kirim email aktivasi
        try {
            Mail::to($register->email)->send(new ActivationMail($register, $activationLink));
        } catch (\Exception $e) {
            // Log error jika pengiriman email gagal, tapi tetap lanjutkan proses registrasi
            \Log::error('Gagal mengirim email aktivasi ke ' . $register->email . ': ' . $e->getMessage());
            // Anda bisa menambahkan respons error spesifik jika ingin
        }


        return response()->json([
            "status" => true,
            "message" => "Pendaftaran berhasil. Silahkan cek email Anda untuk aktivasi akun.",
            "data" => [
                "username" => $register->username,
                "email" => $register->email,
                "nama_lengkap" => $register->nama_lengkap,
                "nik_ktp" => $register->nik_ktp, // Tambahkan nik_ktp di respons
                // Password tidak ditampilkan untuk keamanan
                "activation_key" => $register->activation_key,
            ]
        ], 201); // 201 Created
    }

    /**
     * Handle account activation.
     */
    public function activate(Request $request)
    {
        $activationKey = $request->query('activation');

        if (!$activationKey) {
            return response()->json([
                "status" => false,
                "message" => "Kunci aktivasi tidak ditemukan."
            ], 400);
        }

        $user = Register::where('activation_key', $activationKey)->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Kunci aktivasi tidak valid atau sudah digunakan."
            ], 404);
        }

        if ($user->verified_at) {
            return response()->json([
                "status" => false,
                "message" => "Akun sudah aktif sebelumnya."
            ], 409); // Conflict
        }

        $user->verified_at = now(); // Set waktu verifikasi
        $user->activation_key = null; // Hapus kunci aktivasi setelah digunakan
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "Akun Anda berhasil diaktifkan. Silahkan masuk."
        ]);
    }
}
