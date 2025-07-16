<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest; // Tetap gunakan LoginRequest, akan disesuaikan
use App\Models\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetMail;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;

class AuthController extends Controller
{
    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $nikKtp = $request->input('nik_ktp');
        $password = $request->input('password');

        $user = Register::where('nik_ktp', $nikKtp)->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "NIK KTP atau password tidak valid."
            ], 401);
        }

        // Periksa apakah akun sudah diverifikasi
        if (!$user->verified_at) {
            return response()->json([
                "status" => false,
                "message" => "Akun Anda belum diaktifkan. Silahkan cek email Anda untuk aktivasi."
            ], 403);
        }

        // Coba otentikasi pengguna
        if (!Hash::check($password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "NIK KTP atau password tidak valid."
            ], 401);
        }

        // Jika otentikasi berhasil, buat token API
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "Login berhasil.",
            "data" => [
                "id" => (string) $user->id,
                "nik" => $user->nik_ktp,
                "email" => $user->email,
                "nama" => $user->nama_lengkap,
                "telepon" => $user->telepon ?? null,
                "tgl_lahir" => $user->tgl_lahir ? $user->tgl_lahir->toDateString() : null,
                "token" => $token,
                "status" => $user->verified_at ? "1" : "0",
                "created_at" => $user->created_at ? $user->created_at->toDateTimeString() : null,
                "last_update" => $user->updated_at ? $user->updated_at->toDateTimeString() : null,
            ]
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => "Logout berhasil."
        ]);
    }

    /**
     * Kirim tautan reset password ke email pengguna.
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $identifier = $request->input('identifier');

        $user = Register::where('email', $identifier)
                        ->orWhere('nik_ktp', $identifier)
                        ->first();

        if (!$user) {
            return response()->json([
                "status" => true,
                "message" => "Jika akun Anda terdaftar, tautan reset password telah dikirim ke email Anda."
            ]);
        }

        DB::table('password_resets')->where('email', $user->email)->delete();

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetLink = url('/reset-password?token=' . $token . '&email=' . $user->email);

        \Log::info('Generated reset password link for ' . $user->email . ': ' . $resetLink);

        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $resetLink));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email reset password ke ' . $user->email . ': ' . $e->getMessage());
        }

        return response()->json([
            "status" => true,
            "message" => "Jika akun Anda terdaftar, tautan reset password telah dikirim ke email Anda."
        ]);
    }

    /**
     * Reset password pengguna.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        $password = $request->input('password');

        $passwordReset = DB::table('password_resets')
                            ->where('email', $email)
                            ->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return response()->json([
                "status" => false,
                "message" => "Token reset password tidak valid atau sudah kedaluwarsa."
            ], 400);
        }

        if (now()->diffInMinutes($passwordReset->created_at) > config('auth.passwords.registers.expire', 60)) {
            DB::table('password_resets')->where('email', $email)->delete();
            return response()->json([
                "status" => false,
                "message" => "Token reset password sudah kedaluwarsa. Silakan minta tautan baru."
            ], 400);
        }

        $user = Register::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Pengguna tidak ditemukan."
            ], 404);
        }

        $user->password = bcrypt($password);
        $user->save();

        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([
            "status" => true,
            "message" => "Password Anda berhasil direset. Silahkan login dengan password baru Anda."
        ]);
    }

    /**
     * Handle admin login.
     */
    public function adminLogin(Request $request) // Menggunakan Request biasa karena validasi khusus
    {
        // Validasi input secara manual karena LoginRequest spesifik untuk nik_ktp
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username'); // Ambil username dari request
        $password = $request->input('password');

        $admin = Register::where('username', $username) // Cari berdasarkan username
                         ->where('role', 'admin') // Pastikan role adalah 'admin'
                         ->first();

        if (!$admin) {
            return response()->json([
                "status" => false,
                "message" => "Username atau password admin tidak valid atau akun tidak memiliki akses admin."
            ], 401);
        }

        if (!Hash::check($password, $admin->password)) {
            return response()->json([
                "status" => false,
                "message" => "Username atau password admin tidak valid atau akun tidak memiliki akses admin."
            ], 401);
        }

        // Periksa apakah akun admin sudah diverifikasi (opsional, tergantung kebutuhan)
        if (!$admin->verified_at) {
            return response()->json([
                "status" => false,
                "message" => "Akun admin Anda belum diaktifkan."
            ], 403);
        }

        // Jika otentikasi berhasil, buat token API untuk admin
        $token = $admin->createToken('admin_auth_token')->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "Login admin berhasil.",
            "data" => [
                "id" => (string) $admin->id,
                "username" => $admin->username, // Sertakan username di respons
                "email" => $admin->email,
                "nama" => $admin->nama_lengkap,
                "telepon" => $admin->telepon ?? null,
                "tgl_lahir" => $admin->tgl_lahir ? $admin->tgl_lahir->toDateString() : null,
                "token" => $token,
                "status" => $admin->verified_at ? "1" : "0",
                "role" => $admin->role, // Sertakan role di respons
                "created_at" => $admin->created_at ? $admin->created_at->toDateTimeString() : null,
                "last_update" => $admin->updated_at ? $admin->updated_at->toDateTimeString() : null,
            ]
        ]);
    }
}
