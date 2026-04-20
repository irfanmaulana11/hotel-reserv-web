<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Marriott Hotels',
                'slug' => 'marriott-hotels',
                'description' => 'Marriott International adalah salah satu jaringan hotel terbesar di dunia dengan berbagai brand premium.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Marriott',
                'website' => 'https://www.marriott.com',
                'is_active' => true,
            ],
            [
                'name' => 'Hilton Hotels',
                'slug' => 'hilton-hotels',
                'description' => 'Hilton adalah brand hotel internasional yang menawarkan pengalaman menginap berkelas dunia.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Hilton',
                'website' => 'https://www.hilton.com',
                'is_active' => true,
            ],
            [
                'name' => 'Accor Hotels',
                'slug' => 'accor-hotels',
                'description' => 'Accor adalah grup hotel Eropa dengan berbagai brand dari budget hingga luxury.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Accor',
                'website' => 'https://www.accor.com',
                'is_active' => true,
            ],
            [
                'name' => 'InterContinental Hotels',
                'slug' => 'intercontinental-hotels',
                'description' => 'IHG adalah salah satu grup hotel terbesar dengan brand seperti InterContinental, Holiday Inn, dan Crowne Plaza.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=IHG',
                'website' => 'https://www.ihg.com',
                'is_active' => true,
            ],
            [
                'name' => 'Hyatt Hotels',
                'slug' => 'hyatt-hotels',
                'description' => 'Hyatt adalah brand hotel mewah dengan layanan premium dan fasilitas kelas dunia.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Hyatt',
                'website' => 'https://www.hyatt.com',
                'is_active' => true,
            ],
            [
                'name' => 'Four Seasons',
                'slug' => 'four-seasons',
                'description' => 'Four Seasons adalah brand hotel ultra-luxury dengan standar layanan tertinggi.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Four+Seasons',
                'website' => 'https://www.fourseasons.com',
                'is_active' => true,
            ],
            [
                'name' => 'Shangri-La Hotels',
                'slug' => 'shangri-la-hotels',
                'description' => 'Shangri-La adalah brand hotel Asia dengan keramahan khas oriental dan fasilitas mewah.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Shangri-La',
                'website' => 'https://www.shangri-la.com',
                'is_active' => true,
            ],
            [
                'name' => 'Aston Hotels',
                'slug' => 'aston-hotels',
                'description' => 'Aston adalah brand hotel lokal Indonesia dengan berbagai properti di seluruh nusantara.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Aston',
                'website' => 'https://www.astonhotelsinternational.com',
                'is_active' => true,
            ],
            [
                'name' => 'Santika Hotels',
                'slug' => 'santika-hotels',
                'description' => 'Hotel Santika adalah jaringan hotel Indonesia dengan layanan berkualitas dan harga kompetitif.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Santika',
                'website' => 'https://www.santika.com',
                'is_active' => true,
            ],
            [
                'name' => 'Favehotel',
                'slug' => 'favehotel',
                'description' => 'Favehotel adalah brand budget hotel Indonesia dengan konsep modern dan affordable.',
                'logo_url' => 'https://via.placeholder.com/200x100?text=Favehotel',
                'website' => 'https://www.favehotels.com',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
