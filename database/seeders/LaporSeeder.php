<?php

namespace Database\Seeders;

use App\Models\Lapor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LaporSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/lapor.json');

        if (!File::exists($path)) {
            $this->command->error("File JSON tidak ditemukan: $path");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        foreach ($data as $row) {
            Lapor::updateOrCreate(
                ['id' => $row['id']], // berdasarkan ID, agar tidak duplikat
                collect($row)->except(['id'])->toArray() // sisanya sebagai isian
            );
        }

        $this->command->info('Data laporan berhasil dimasukkan.');
    }
}
