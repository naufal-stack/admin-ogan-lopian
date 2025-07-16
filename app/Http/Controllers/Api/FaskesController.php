<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

use App\Services\Dashboard;
use App\Services\Superadmin;
use App\Services\AuthModel;

class FaskesController extends Controller
{
    public function index()
    {
        $userId = Session::get('id');
        $roleId = Session::get('id_role');

        // Pastikan service-service ini sudah dibuat atau sesuaikan dengan model Anda
        $data = [
            'title' => 'PURBAKESA',
            'headtitle' => 'Dashboard',
            'telepon' => '02648393004',
            'role' => Dashboard::getRoleName($roleId),
            'totalpesan' => Dashboard::getCountPesan($userId),
            'pesan' => Dashboard::getPesan($userId),
            'profile' => AuthModel::getProfile($userId),
            'obat_masuk' => Dashboard::countObatMasukPkm(),
            'obat_keluar' => Dashboard::countObatKeluarPkm(),
            'puskesmas' => Dashboard::countPuskesmas(),
            'pasien' => Dashboard::countPasien(),
            'kes_pria' => Superadmin::getGrafikKesehatan('laki-laki'),
            'kes_perempuan' => Superadmin::getGrafikKesehatan('perempuan'),
        ];

        // Panggil API BPJS menggunakan Laravel HTTP client
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Cookie' => 'BIGipServerPool_faskes_new=1917261740.20480.0000; TS015440f3=01a864b11a5bf691a73b469d6cb73abb334e700fd3d7ae36d789b8c7db81865818814751a6868e420881ed18e0da485eb72e9e7bf16fb1d6233185efc859e3d3c9bc69cbb5'
        ])->post('https://faskes.bpjs-kesehatan.go.id/aplicares/Pencarian/getList', [
            'jnscari' => 'carifaskes',
            'jnscari1' => 'bylocation',
            'dati2ppk' => '0130',
            'jnsppk' => 'R',
        ]);

        // Jika response gagal, tangani error
        if ($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data dari BPJS',
                'data' => null
            ], 500);
        }

        $data['datars'] = $response->json();

        return response()->json([
            'status' => true,
            'message' => 'Data dashboard berhasil dimuat',
            'data' => $data
        ]);
    }
}
