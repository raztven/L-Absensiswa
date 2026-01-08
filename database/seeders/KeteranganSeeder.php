<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeteranganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['keterangan' => 'Hadir'],
            ['keterangan' => 'Sakit'],
            ['keterangan' => 'Izin'],
            ['keterangan' => 'Alpa'],
            ['keterangan' => 'Terlambat'],
        ];

        DB::table('keterangan')->insert($data);
    }
}