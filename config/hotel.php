<?php

return [
    'brands' => [
        ['name' => 'Hotel ABC Collection', 'slug' => 'collection', 'description' => 'Pilihan properti unggulan di kota besar.'],
        ['name' => 'ABC Essence', 'slug' => 'essence', 'description' => 'Kenyamanan hangat dengan sentuhan lokal.'],
        ['name' => 'Front One by ABC', 'slug' => 'front-one', 'description' => 'Efisien dan ramah untuk perjalanan bisnis.'],
    ],

    'destinations' => [
        ['city' => 'Jakarta', 'hotels' => 4, 'rooms' => 181, 'image' => 'https://images.unsplash.com/photo-1555400038-63f404082e21?w=800&q=80'],
        ['city' => 'Semarang', 'hotels' => 8, 'rooms' => 397, 'image' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=800&q=80'],
        ['city' => 'Solo', 'hotels' => 7, 'rooms' => 284, 'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80'],
        ['city' => 'Yogyakarta', 'hotels' => 5, 'rooms' => 245, 'image' => 'https://images.unsplash.com/photo-1589308078059-be1415eab4c3?w=800&q=80'],
        ['city' => 'Malang', 'hotels' => 4, 'rooms' => 146, 'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80'],
        ['city' => 'Surabaya', 'hotels' => 1, 'rooms' => 45, 'image' => 'https://images.unsplash.com/photo-1577792245-5d59b30cffb7?w=800&q=80'],
    ],

    'hotels' => [
        [
            'slug' => 'abc-collection-jakarta-sudirman',
            'name' => 'ABC Collection Sudirman',
            'city' => 'Jakarta',
            'showcase_label' => 'SUDIRMAN, JAKARTA',
            'brand' => 'Hotel ABC Collection',
            'rating' => 4.8,
            'description' => 'Di jantung bisnis Jakarta, dengan lounge eksekutif dan kolam renang atap.',
            'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80',
            'rooms' => [
                ['type' => 'Deluxe King', 'price' => 985000, 'max_guests' => 2, 'available_rooms' => 5, 'image' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80'],
                ['type' => 'Executive Suite', 'price' => 1650000, 'max_guests' => 3, 'available_rooms' => 2, 'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&q=80'],
            ],
        ],
        [
            'slug' => 'abc-essence-malioboro',
            'name' => 'ABC Essence Malioboro',
            'city' => 'Yogyakarta',
            'showcase_label' => 'MALIOBORO, YOGYAKARTA',
            'brand' => 'ABC Essence',
            'rating' => 4.7,
            'description' => 'Berjalan kaki ke Malioboro, cocok untuk wisata budaya dan kuliner.',
            'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1200&q=80',
            'rooms' => [
                ['type' => 'Superior Twin', 'price' => 620000, 'max_guests' => 2, 'available_rooms' => 8, 'image' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?w=800&q=80'],
                ['type' => 'Family Room', 'price' => 890000, 'max_guests' => 4, 'available_rooms' => 3, 'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&q=80'],
            ],
        ],
        [
            'slug' => 'front-one-semarang-tengah',
            'name' => 'Front One Semarang Tengah',
            'city' => 'Semarang',
            'showcase_label' => 'SIMPANG LIMA, SEMARANG',
            'brand' => 'Front One by ABC',
            'rating' => 4.5,
            'description' => 'Akses mudah ke Simpang Lima dan kawasan perkantoran.',
            'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e54d34?w=1200&q=80',
            'rooms' => [
                ['type' => 'Smart Room', 'price' => 425000, 'max_guests' => 2, 'available_rooms' => 12, 'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=800&q=80'],
                ['type' => 'Business Queen', 'price' => 510000, 'max_guests' => 2, 'available_rooms' => 6, 'image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80'],
            ],
        ],
        [
            'slug' => 'abc-collection-solo-manahan',
            'name' => 'ABC Collection Manahan Solo',
            'city' => 'Solo',
            'showcase_label' => 'MANAHAN, SOLO',
            'brand' => 'Hotel ABC Collection',
            'rating' => 4.6,
            'description' => 'Arsitektur modern dengan nuansa Jawa yang lembut.',
            'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1200&q=80',
            'rooms' => [
                ['type' => 'Deluxe', 'price' => 720000, 'max_guests' => 2, 'available_rooms' => 7, 'image' => 'https://images.unsplash.com/photo-1611892440504-42a792e54d34?w=800&q=80'],
                ['type' => 'Junior Suite', 'price' => 1100000, 'max_guests' => 3, 'available_rooms' => 1, 'image' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&q=80'],
            ],
        ],
        [
            'slug' => 'abc-essence-malang-batu',
            'name' => 'ABC Essence Batu',
            'city' => 'Malang',
            'showcase_label' => 'BATU, MALANG',
            'brand' => 'ABC Essence',
            'rating' => 4.75,
            'description' => 'Udara sejuk, pemandangan pegunungan, ideal untuk liburan keluarga.',
            'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=1200&q=80',
            'rooms' => [
                ['type' => 'Garden View', 'price' => 780000, 'max_guests' => 2, 'available_rooms' => 4, 'image' => 'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=800&q=80'],
                ['type' => 'Villa Loft', 'price' => 1450000, 'max_guests' => 4, 'available_rooms' => 2, 'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&q=80'],
            ],
        ],
        [
            'slug' => 'front-one-surabaya-tunjungan',
            'name' => 'Front One Tunjungan',
            'city' => 'Surabaya',
            'showcase_label' => 'TUNJUNGAN, SURABAYA',
            'brand' => 'Front One by ABC',
            'rating' => 4.4,
            'description' => 'Dekat Tunjungan Plaza dan jajaran restoran ikonik Surabaya.',
            'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1200&q=80',
            'rooms' => [
                ['type' => 'City Room', 'price' => 465000, 'max_guests' => 2, 'available_rooms' => 9, 'image' => 'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?w=800&q=80'],
            ],
        ],
    ],
];
