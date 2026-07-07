<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Beranda',
                'slug' => 'home',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Struktur Anggota',
                'slug' => 'struktur-anggota',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Program Kerja',
                'slug' => 'program-kerja',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Edukasi',
                'slug' => 'edukasi',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Berita',
                'slug' => 'berita',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Kontak',
                'slug' => 'kontak',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Gabung dengan Kami',
                'slug' => 'gabung',
                'content_blocks' => '[]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Insert ke dalam tabel pages
        DB::table('pages')->insert($pages);
    }
}
