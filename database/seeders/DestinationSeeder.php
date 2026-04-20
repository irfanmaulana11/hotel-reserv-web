<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Jakarta',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'description' => 'Ibu kota Indonesia dengan berbagai atraksi wisata modern, pusat bisnis, dan kuliner yang beragam.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Jakarta',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bali',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'description' => 'Pulau dewata dengan pantai indah, budaya yang kaya, dan destinasi wisata kelas dunia.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Bali',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Yogyakarta',
                'city' => 'Yogyakarta',
                'country' => 'Indonesia',
                'description' => 'Kota budaya dengan Candi Borobudur, Prambanan, Keraton, dan berbagai wisata sejarah.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Yogyakarta',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Bandung',
                'city' => 'Bandung',
                'country' => 'Indonesia',
                'description' => 'Kota kembang dengan udara sejuk, factory outlet, dan wisata alam pegunungan.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Bandung',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Surabaya',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
                'description' => 'Kota pahlawan dengan berbagai wisata sejarah, kuliner khas, dan pusat bisnis Jawa Timur.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Surabaya',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Lombok',
                'city' => 'Mataram',
                'country' => 'Indonesia',
                'description' => 'Pulau dengan pantai eksotis, Gunung Rinjani, dan Gili yang menawan.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Lombok',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Medan',
                'city' => 'Medan',
                'country' => 'Indonesia',
                'description' => 'Kota terbesar di Sumatera dengan kuliner legendaris dan akses ke Danau Toba.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Medan',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Makassar',
                'city' => 'Makassar',
                'country' => 'Indonesia',
                'description' => 'Kota pelabuhan dengan pantai Losari, kuliner seafood, dan pintu gerbang ke Toraja.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Makassar',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Semarang',
                'city' => 'Semarang',
                'country' => 'Indonesia',
                'description' => 'Kota dengan bangunan bersejarah kolonial, Lawang Sewu, dan kuliner lumpia.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Semarang',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Malang',
                'city' => 'Malang',
                'country' => 'Indonesia',
                'description' => 'Kota dengan udara sejuk, wisata Batu, dan berbagai destinasi alam yang indah.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Malang',
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Raja Ampat',
                'city' => 'Waisai',
                'country' => 'Indonesia',
                'description' => 'Surga diving dengan keanekaragaman hayati laut terbaik di dunia.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Raja+Ampat',
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Labuan Bajo',
                'city' => 'Labuan Bajo',
                'country' => 'Indonesia',
                'description' => 'Pintu gerbang ke Taman Nasional Komodo dengan pemandangan laut yang spektakuler.',
                'image_url' => 'https://via.placeholder.com/800x600?text=Labuan+Bajo',
                'is_popular' => true,
                'is_active' => true,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
