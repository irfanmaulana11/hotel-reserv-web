<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            // Setiap hotel punya 2-3 tipe kamar
            $roomTypes = [
                [
                    'type' => 'Deluxe Room',
                    'price' => $hotel->price_per_night * 0.8,
                    'max_guests' => 2,
                    'available_rooms' => rand(5, 15),
                    'description' => 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.',
                    'facilities' => ['wifi', 'ac', 'tv', 'private_bathroom', 'hot_water'],
                ],
                [
                    'type' => 'Executive Suite',
                    'price' => $hotel->price_per_night * 1.5,
                    'max_guests' => 3,
                    'available_rooms' => rand(2, 8),
                    'description' => 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.',
                    'facilities' => ['wifi', 'ac', 'tv', 'breakfast', 'extra_bed', 'private_bathroom', 'hot_water'],
                ],
                [
                    'type' => 'Family Room',
                    'price' => $hotel->price_per_night * 1.2,
                    'max_guests' => 4,
                    'available_rooms' => rand(3, 10),
                    'description' => 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.',
                    'facilities' => ['wifi', 'ac', 'tv', 'extra_bed', 'private_bathroom', 'hot_water'],
                ],
            ];

            foreach ($roomTypes as $roomData) {
                Room::create([
                    'hotel_id' => $hotel->id,
                    'type' => $roomData['type'],
                    'price' => $roomData['price'],
                    'max_guests' => $roomData['max_guests'],
                    'available_rooms' => $roomData['available_rooms'],
                    'image_url' => 'https://via.placeholder.com/800x600?text='.$roomData['type'],
                    'description' => $roomData['description'],
                    'facilities' => $roomData['facilities'],
                    'is_active' => true,
                ]);
            }
        }
    }
}
