<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Residents;
use Faker\Factory as Faker;

class ResidentsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kecamatanList = [
            "Bangsal","Dawarblandong","Dlanggu","Gedeg","Gondang","Jatirejo","Jetis","Kemlagi",
            "Kutorejo","Mojoanyar","Mojosari","Ngoro","Pacet","Pungging","Puri","Sooko","Trawas","Trowulan"
        ];

        $pendapatanList = [
            "<800.000",
            "800.000 - 1,2jt",
            "1,2jt - 1,8jt",
            "1,8jt - 2,4jt",
            ">2,4jt"
        ];

        $bansosList = ["PKH", "Sembako", "PBI-JK", "YAPI", "Lain - Lain"];

        for ($i = 1; $i <= 100; $i++) {
            $bansos = $faker->randomElement($bansosList);
            if ($bansos === "Lain - Lain") {
                $bansos = "Lain - Lain (" . $faker->word . ")";
            }

            Residents::create([
                'no_kk' => $faker->unique()->numerify('35##########'),
                'no_nik_kepala_keluarga' => $faker->unique()->numerify('35##############'),
                'nama_kepala_keluarga' => $faker->name,
                'alamat' => $faker->address,
                'kecamatan' => $faker->randomElement($kecamatanList),
                'kelurahan' => $faker->streetName,
                'status_kepemilikan_rumah' => $faker->randomElement(['Milik Sendiri', 'Kontrak/Sewa', 'Menumpang']),
                'usaha' => $faker->company,
                'jumlah_keluarga' => $faker->numberBetween(2, 7),
                'jenis_lantai' => $faker->randomElement(['Marmer/Granit','Keramik','Kayu/Papan','Semen/Bata Merah','Tanah']),
                'jenis_dinding' => $faker->randomElement(['Tembok','Kayu/Papan','Anyaman Bambu']),
                'jenis_atap' => $faker->randomElement(['Genteng','Seng','Asbes','Bambu','Kayu/Sirap']),
                'sumber_air_minum' => $faker->randomElement(['Air Kemasan','Sumur','Leding','Mata Air','Air Hujan']),
                'daya_listrik' => $faker->randomElement(['450 VA','900 VA','1300 VA','2200 VA']),
                'id_meter_pln' => $faker->numerify('#########'),
                'bahan_bakar_memasak' => $faker->randomElement(['Gas Elpiji','Listrik','Kayu Bakar','Arang','Tidak Memasak']),
                'fasilitas_bab' => $faker->randomElement(['Sendiri','Bersama','MCK Umum','Tidak Ada']),
                'jenis_kloset' => $faker->randomElement(['Leher Angsa','Plengsengan','Cemplung']),
                'pembuangan_tinja' => $faker->randomElement(['Tangki Septik','Lubang Tanah','IPAL','Sungai']),
                'asset_bergerak' => $faker->words(3, true),
                'asset_tidak_bergerak' => $faker->words(2, true),
                'ternak' => $faker->randomElement(['Sapi','Kambing','Ayam','Itik','Tidak Ada']),
                'pendapatan' => $faker->randomElement($pendapatanList),
                'foto_rumah' => null,
                'foto_tampak_dalam' => null,
                'foto_kamar_mandi' => null,
                'bansos' => $bansos,
                'longitude' => $faker->longitude(112.3, 112.7),
                'latitude' => $faker->latitude(-7.7, -7.3),
            ]);
        }
    }
}
