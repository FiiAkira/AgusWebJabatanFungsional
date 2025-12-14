<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user default untuk login (jika belum ada)
        $userEmail = 'admin@unmus.ac.id';

        if (!User::where('email', $userEmail)->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => $userEmail,
                'password' => Hash::make('password'), // password: "password"
            ]);
        }

        $this->call([
            DocumentCategorySeeder::class,
        ]);

        // Anda bisa menambahkan lebih banyak seed di sini (kategori, dokumen, dll.)
    }
}
