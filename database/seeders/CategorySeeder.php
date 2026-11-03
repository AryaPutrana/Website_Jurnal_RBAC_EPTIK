<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Teknologi Informasi',
                'description' => 'Artikel tentang teknologi informasi, sistem komputer, dan perkembangan teknologi digital.',
            ],
            [
                'name' => 'Keamanan Sistem',
                'description' => 'Artikel tentang keamanan jaringan, cybersecurity, dan proteksi data.',
            ],
            [
                'name' => 'Etika Profesi',
                'description' => 'Artikel tentang etika dalam profesi IT, tanggung jawab profesional, dan kode etik.',
            ],
            [
                'name' => 'Rekayasa Perangkat Lunak',
                'description' => 'Artikel tentang pengembangan software, metodologi, dan best practices.',
            ],
            [
                'name' => 'Basis Data',
                'description' => 'Artikel tentang sistem basis data, database management, dan optimasi query.',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
