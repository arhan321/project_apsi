<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'description' => "pt untung terus adalah toko yang menyediakan barang barang kebutuhan manusia, dan berjualan makanan ringan, berkulitas tinggi dan harga terjangkau.",
            'short_des' => "pt untung terus berjulann di daerah bitung, memiliki kantor yang bersih dan rapih, dan memiliki karyawan yang ramah dan sopan.",
            'photo' => "https://apsi.djncloud.my.id/storage/photos/1/logo_toko/Screenshot 2024-06-20 012800.png",
            'logo' => 'https://apsi.djncloud.my.id/storage/photos/1/logo_toko/Screenshot 2024-06-20 012800.png',
            'address' => "bitung di dekat torabika, (pesaing pabrik torabika)",
            'email' => "untungrugi@gmail.com",
            'phone' => "082112121212",
        ];

        DB::table('settings')->insert($data);
    }
}
