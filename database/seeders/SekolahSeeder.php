<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // <--- Tambahkan ini

class SekolahSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/sd_sekolah.json');

        if (!File::exists($path)) {
            $this->command->error("File not found: $path");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        foreach ($data as $row) {
            DB::table('sekolahs')->updateOrInsert(
                ['npsn' => $row['npsn']], // Hindari duplikat
                $row
            );
        }

        $this->command->info("Data sekolah berhasil dimasukkan dari JSON.");
    }
}
