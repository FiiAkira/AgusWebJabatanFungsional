<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\DB;

class DocumentCategorySeeder extends Seeder
{
    public function run()
    {
        // Kita kosongkan dulu tabelnya biar tidak duplikat saat di-run ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DocumentCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            'Bidang A - Pendidikan & Pengajaran',
            'Bidang B - Penelitian & Karya Ilmiah',
            'Bidang C - Pengabdian Masyarakat',
            'Bidang D - Penunjang Tri Dharma',
            'Lainnya (Belum Dikategorikan)' // Opsi tambahan jika dosen bingung
        ];

        foreach ($data as $item) {
            DocumentCategory::create([
                'name' => $item
            ]);
        }
    }
}