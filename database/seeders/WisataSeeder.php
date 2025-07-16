<?php

namespace Database\Seeders;

use App\Models\Wisata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WisataSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/wisata.json');

        if (!File::exists($path)) {
            $this->command->error("File tidak ditemukan: $path");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        foreach ($data as $row) {
            // Hapus field 'alamat' agar tidak dikirim ke model
            unset($row['alamat']);

            Wisata::updateOrCreate(
                ['id' => $row['id']],
                $row
            );
        }

        $this->command->info("Data wisata berhasil dimasukkan.");
    }
}
