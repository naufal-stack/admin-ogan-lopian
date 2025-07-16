<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Dashboard
{
    public static function countPuskesmas()
    {
        return DB::table('tbl_puskesmas')->count();
    }

    public static function countPasien()
    {
        return DB::table('tbl_pasien')
            ->whereDate('created_at', now()->toDateString())
            ->count();
    }

    public static function countObatMasukPkm()
    {
        return DB::table('tbl_obat_masuk_puskesmas')
            ->whereDate('created_at', now()->toDateString())
            ->count();
    }

    public static function countObatKeluarPkm()
    {
        return DB::table('tbl_obat_keluar_puskesmas')
            ->whereDate('created_at', now()->toDateString())
            ->count();
    }

    public static function getRoleName($id)
    {
        return DB::table('tbl_role')->where('id', $id)->value('nama');
    }

    public static function getRole()
    {
        return DB::table('tbl_role')->orderBy('nama')->get();
    }

    public static function getPesan($penerima)
    {
        return DB::table('tbl_pesan as a')
            ->join('tbl_users as b', 'a.id_pengirim', '=', 'b.id')
            ->select('a.*', 'b.nama as pengirim', 'b.image')
            ->where('a.id_penerima', $penerima)
            ->where('a.status', 'unread')
            ->orderByDesc('a.id')
            ->get();
    }

    public static function getCountPesan($penerima)
    {
        return DB::table('tbl_pesan')
            ->where('id_penerima', $penerima)
            ->where('status', 'unread')
            ->count();
    }

    public static function getReadMessage($slug, $user)
    {
        return DB::table('tbl_pesan as a')
            ->join('tbl_users as b', 'a.id_pengirim', '=', 'b.id')
            ->select('a.*', 'b.nama as pengirim')
            ->where('a.slug', $slug)
            ->where(function ($query) use ($user) {
                $query->where('a.id_pengirim', $user)
                      ->orWhere('a.id_penerima', $user);
            })
            ->first();
    }

    public static function getMessage($user)
    {
        return DB::table('tbl_pesan as a')
            ->join('tbl_users as b', 'a.id_pengirim', '=', 'b.id')
            ->select('a.*', 'b.nama as pengirim')
            ->where('a.id_penerima', $user)
            ->orderByDesc('a.created_at')
            ->orderBy('a.status')
            ->get();
    }

    public static function getLog($user)
    {
        return DB::table('tbl_log')
            ->where('id_user', $user)
            ->orderByDesc('created_at')
            ->get();
    }

    public static function getUsers($role_id)
    {
        $id = Auth::id(); // atau sesuaikan jika pakai Session::get('id');
        return DB::table('tbl_users')
            ->where('id_role', $role_id)
            ->where('id', '!=', $id)
            ->get();
    }

    public static function getKodeBarangMasuk()
    {
        $prefix = 'JT-' . now()->format('Ymd') . '-';
        $lastKode = DB::table('tbl_obat_masuk')
            ->whereDate('created_at', now())
            ->select(DB::raw("MAX(RIGHT(kode_transaksi,5)) as kode"))
            ->first();

        $number = $lastKode && $lastKode->kode ? (int)$lastKode->kode + 1 : 1;

        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public static function getKodeBarangKeluar()
    {
        $prefix = 'JT-' . now()->format('Ymd') . '-';
        $lastKode = DB::table('tbl_obat_keluar')
            ->whereDate('created_at', now())
            ->select(DB::raw("MAX(RIGHT(kode_transaksi,5)) as kode"))
            ->first();

        $number = $lastKode && $lastKode->kode ? (int)$lastKode->kode + 1 : 1;

        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public static function getKecamatan()
    {
        return DB::table('tbl_kecamatan')
            ->orderBy('nama')
            ->get();
    }

    public static function getPuskesmas()
    {
        return DB::table('tbl_puskesmas as a')
            ->join('tbl_kecamatan as b', 'a.id_kecamatan', '=', 'b.id')
            ->select('a.*', 'b.nama as kecamatan')
            ->orderBy('b.nama')
            ->get();
    }

    public static function getPasien($pkm)
    {
        return DB::table('tbl_pasien as a')
            ->join('tbl_users as b', 'a.id_user', '=', 'b.id')
            ->where('b.id_pkm', $pkm)
            ->orderBy('a.nama')
            ->get();
    }

    public static function getToken($nama)
    {
        return DB::table('tbl_token')->where('nama', $nama)->first();
    }

    public static function cekToken($nama, $waktu)
    {
        return DB::table('tbl_token')
            ->where('nama', $nama)
            ->where(DB::raw("LEFT(updated_at,13)"), '<', $waktu)
            ->first();
    }
}
