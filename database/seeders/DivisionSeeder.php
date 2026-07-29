<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $d1 = Division::firstOrCreate(
            ['name' => 'Pengurus Harian'],
            ['description' => 'Mengoordinasikan dan mengarahkan seluruh kegiatan serta arah kebijakan organisasi.', 'order' => 1]
        );

        $d2 = Division::firstOrCreate(
            ['name' => 'Divisi Komunikasi & Informasi'],
            ['description' => 'Mengelola publikasi, hubungan masyarakat, dan media komunikasi publik.', 'order' => 2]
        );

        Member::whereNull('division_id')->orWhere('division_id', 0)->update(['division_id' => $d1->id]);
    }
}
