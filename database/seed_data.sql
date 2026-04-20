-- ============================================
-- Hotel Reservation Web - MySQL Data Dummy
-- Database: hotel_reserv_web
-- ============================================

USE hotel_reserv_web;

-- ============================================
-- Insert Migration Records
-- ============================================
INSERT INTO migrations (migration, batch) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2026_04_15_041746_create_hotels_table', 1),
('2026_04_15_042303_create_destinations_table', 1),
('2026_04_15_042303_create_brands_table', 1),
('2026_04_15_042839_create_rooms_table', 1),
('2026_04_15_042840_create_reservations_table', 1);

-- ============================================
-- Insert Dummy Users
-- ============================================
-- Password: password (hashed with bcrypt)
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Test User', 'test@example.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6V.mSu', NULL, NOW(), NOW()),
('Admin User', 'admin@hotel-reserv.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6V.mSu', NULL, NOW(), NOW()),
('John Doe', 'john.doe@example.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6V.mSu', NULL, NOW(), NOW()),
('Jane Smith', 'jane.smith@example.com', NULL, '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6V.mSu', NULL, NOW(), NOW()),
('Bob Wilson', 'bob.wilson@example.com', NOW(), '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5NANClx6V.mSu', NULL, NOW(), NOW());

-- ============================================
-- Note: Password untuk semua user adalah "password"
-- ============================================

-- ============================================
-- Insert Dummy Hotels
-- ============================================
INSERT INTO hotels (name, address, city, country, phone, email, star_rating, description, price_per_night, total_rooms, available_rooms, image_url, is_active, created_at, updated_at) VALUES
('Grand Luxury Hotel Jakarta', 'Jl. Sudirman No. 123', 'Jakarta', 'Indonesia', '+62-21-12345678', 'info@grandluxury.com', 5, 'Hotel bintang 5 dengan fasilitas lengkap di pusat kota Jakarta. Menawarkan pemandangan kota yang menakjubkan dan layanan premium.', 1500000.00, 200, 150, 'https://via.placeholder.com/800x600?text=Grand+Luxury+Hotel', 1, NOW(), NOW()),
('Bali Beach Resort', 'Jl. Pantai Kuta No. 88', 'Bali', 'Indonesia', '+62-361-987654', 'reservation@balibeach.com', 5, 'Resort tepi pantai dengan pemandangan laut yang indah. Fasilitas spa, kolam renang infinity, dan restoran fine dining.', 2000000.00, 150, 100, 'https://via.placeholder.com/800x600?text=Bali+Beach+Resort', 1, NOW(), NOW()),
('Bandung Mountain Hotel', 'Jl. Dago Pakar No. 45', 'Bandung', 'Indonesia', '+62-22-555666', 'contact@bandungmountain.com', 4, 'Hotel di kawasan pegunungan dengan udara sejuk dan pemandangan alam yang asri. Cocok untuk liburan keluarga.', 800000.00, 100, 75, 'https://via.placeholder.com/800x600?text=Bandung+Mountain+Hotel', 1, NOW(), NOW()),
('Surabaya Business Hotel', 'Jl. HR Muhammad No. 234', 'Surabaya', 'Indonesia', '+62-31-777888', 'info@surabayabusiness.com', 4, 'Hotel bisnis modern dengan fasilitas meeting room dan business center. Lokasi strategis dekat pusat bisnis.', 900000.00, 120, 90, 'https://via.placeholder.com/800x600?text=Surabaya+Business+Hotel', 1, NOW(), NOW()),
('Yogyakarta Heritage Inn', 'Jl. Malioboro No. 56', 'Yogyakarta', 'Indonesia', '+62-274-333444', 'booking@yogyaheritage.com', 3, 'Hotel dengan nuansa tradisional Jawa di jantung kota Yogyakarta. Dekat dengan Malioboro dan Keraton.', 500000.00, 80, 60, 'https://via.placeholder.com/800x600?text=Yogyakarta+Heritage+Inn', 1, NOW(), NOW()),
('Lombok Paradise Hotel', 'Jl. Senggigi Beach No. 12', 'Lombok', 'Indonesia', '+62-370-111222', 'info@lombokparadise.com', 4, 'Hotel tepi pantai dengan akses langsung ke Pantai Senggigi. Menawarkan aktivitas snorkeling dan diving.', 1200000.00, 90, 70, 'https://via.placeholder.com/800x600?text=Lombok+Paradise+Hotel', 1, NOW(), NOW()),
('Medan City Center Hotel', 'Jl. Imam Bonjol No. 78', 'Medan', 'Indonesia', '+62-61-444555', 'reservation@medancity.com', 3, 'Hotel budget di pusat kota Medan dengan fasilitas memadai dan harga terjangkau.', 450000.00, 70, 50, 'https://via.placeholder.com/800x600?text=Medan+City+Center+Hotel', 1, NOW(), NOW()),
('Makassar Waterfront Hotel', 'Jl. Penghibur No. 90', 'Makassar', 'Indonesia', '+62-411-666777', 'contact@makassarwaterfront.com', 4, 'Hotel modern dengan pemandangan laut Makassar. Fasilitas rooftop bar dan restaurant.', 950000.00, 110, 85, 'https://via.placeholder.com/800x600?text=Makassar+Waterfront+Hotel', 1, NOW(), NOW()),
('Semarang Colonial Hotel', 'Jl. Pemuda No. 123', 'Semarang', 'Indonesia', '+62-24-888999', 'info@semarangcolonial.com', 3, 'Hotel dengan arsitektur kolonial yang unik. Lokasi strategis dekat Lawang Sewu dan Sam Poo Kong.', 600000.00, 60, 45, 'https://via.placeholder.com/800x600?text=Semarang+Colonial+Hotel', 1, NOW(), NOW()),
('Malang Highland Resort', 'Jl. Raya Batu No. 67', 'Malang', 'Indonesia', '+62-341-222333', 'booking@malanghighland.com', 4, 'Resort di kawasan pegunungan Batu dengan udara sejuk dan pemandangan indah. Cocok untuk family gathering.', 750000.00, 85, 65, 'https://via.placeholder.com/800x600?text=Malang+Highland+Resort', 1, NOW(), NOW());

-- ============================================
-- Insert Dummy Destinations
-- ============================================
INSERT INTO destinations (name, city, country, description, image_url, is_popular, is_active, created_at, updated_at) VALUES
('Jakarta', 'Jakarta', 'Indonesia', 'Ibu kota Indonesia dengan berbagai atraksi wisata modern, pusat bisnis, dan kuliner yang beragam.', 'https://via.placeholder.com/800x600?text=Jakarta', 1, 1, NOW(), NOW()),
('Bali', 'Denpasar', 'Indonesia', 'Pulau dewata dengan pantai indah, budaya yang kaya, dan destinasi wisata kelas dunia.', 'https://via.placeholder.com/800x600?text=Bali', 1, 1, NOW(), NOW()),
('Yogyakarta', 'Yogyakarta', 'Indonesia', 'Kota budaya dengan Candi Borobudur, Prambanan, Keraton, dan berbagai wisata sejarah.', 'https://via.placeholder.com/800x600?text=Yogyakarta', 1, 1, NOW(), NOW()),
('Bandung', 'Bandung', 'Indonesia', 'Kota kembang dengan udara sejuk, factory outlet, dan wisata alam pegunungan.', 'https://via.placeholder.com/800x600?text=Bandung', 1, 1, NOW(), NOW()),
('Surabaya', 'Surabaya', 'Indonesia', 'Kota pahlawan dengan berbagai wisata sejarah, kuliner khas, dan pusat bisnis Jawa Timur.', 'https://via.placeholder.com/800x600?text=Surabaya', 0, 1, NOW(), NOW()),
('Lombok', 'Mataram', 'Indonesia', 'Pulau dengan pantai eksotis, Gunung Rinjani, dan Gili yang menawan.', 'https://via.placeholder.com/800x600?text=Lombok', 1, 1, NOW(), NOW()),
('Medan', 'Medan', 'Indonesia', 'Kota terbesar di Sumatera dengan kuliner legendaris dan akses ke Danau Toba.', 'https://via.placeholder.com/800x600?text=Medan', 0, 1, NOW(), NOW()),
('Makassar', 'Makassar', 'Indonesia', 'Kota pelabuhan dengan pantai Losari, kuliner seafood, dan pintu gerbang ke Toraja.', 'https://via.placeholder.com/800x600?text=Makassar', 0, 1, NOW(), NOW()),
('Semarang', 'Semarang', 'Indonesia', 'Kota dengan bangunan bersejarah kolonial, Lawang Sewu, dan kuliner lumpia.', 'https://via.placeholder.com/800x600?text=Semarang', 0, 1, NOW(), NOW()),
('Malang', 'Malang', 'Indonesia', 'Kota dengan udara sejuk, wisata Batu, dan berbagai destinasi alam yang indah.', 'https://via.placeholder.com/800x600?text=Malang', 0, 1, NOW(), NOW()),
('Raja Ampat', 'Waisai', 'Indonesia', 'Surga diving dengan keanekaragaman hayati laut terbaik di dunia.', 'https://via.placeholder.com/800x600?text=Raja+Ampat', 1, 1, NOW(), NOW()),
('Labuan Bajo', 'Labuan Bajo', 'Indonesia', 'Pintu gerbang ke Taman Nasional Komodo dengan pemandangan laut yang spektakuler.', 'https://via.placeholder.com/800x600?text=Labuan+Bajo', 1, 1, NOW(), NOW());

-- ============================================
-- Insert Dummy Brands
-- ============================================
INSERT INTO brands (name, slug, description, logo_url, website, is_active, created_at, updated_at) VALUES
('Marriott Hotels', 'marriott-hotels', 'Marriott International adalah salah satu jaringan hotel terbesar di dunia dengan berbagai brand premium.', 'https://via.placeholder.com/200x100?text=Marriott', 'https://www.marriott.com', 1, NOW(), NOW()),
('Hilton Hotels', 'hilton-hotels', 'Hilton adalah brand hotel internasional yang menawarkan pengalaman menginap berkelas dunia.', 'https://via.placeholder.com/200x100?text=Hilton', 'https://www.hilton.com', 1, NOW(), NOW()),
('Accor Hotels', 'accor-hotels', 'Accor adalah grup hotel Eropa dengan berbagai brand dari budget hingga luxury.', 'https://via.placeholder.com/200x100?text=Accor', 'https://www.accor.com', 1, NOW(), NOW()),
('InterContinental Hotels', 'intercontinental-hotels', 'IHG adalah salah satu grup hotel terbesar dengan brand seperti InterContinental, Holiday Inn, dan Crowne Plaza.', 'https://via.placeholder.com/200x100?text=IHG', 'https://www.ihg.com', 1, NOW(), NOW()),
('Hyatt Hotels', 'hyatt-hotels', 'Hyatt adalah brand hotel mewah dengan layanan premium dan fasilitas kelas dunia.', 'https://via.placeholder.com/200x100?text=Hyatt', 'https://www.hyatt.com', 1, NOW(), NOW()),
('Four Seasons', 'four-seasons', 'Four Seasons adalah brand hotel ultra-luxury dengan standar layanan tertinggi.', 'https://via.placeholder.com/200x100?text=Four+Seasons', 'https://www.fourseasons.com', 1, NOW(), NOW()),
('Shangri-La Hotels', 'shangri-la-hotels', 'Shangri-La adalah brand hotel Asia dengan keramahan khas oriental dan fasilitas mewah.', 'https://via.placeholder.com/200x100?text=Shangri-La', 'https://www.shangri-la.com', 1, NOW(), NOW()),
('Aston Hotels', 'aston-hotels', 'Aston adalah brand hotel lokal Indonesia dengan berbagai properti di seluruh nusantara.', 'https://via.placeholder.com/200x100?text=Aston', 'https://www.astonhotelsinternational.com', 1, NOW(), NOW()),
('Santika Hotels', 'santika-hotels', 'Hotel Santika adalah jaringan hotel Indonesia dengan layanan berkualitas dan harga kompetitif.', 'https://via.placeholder.com/200x100?text=Santika', 'https://www.santika.com', 1, NOW(), NOW()),
('Favehotel', 'favehotel', 'Favehotel adalah brand budget hotel Indonesia dengan konsep modern dan affordable.', 'https://via.placeholder.com/200x100?text=Favehotel', 'https://www.favehotels.com', 1, NOW(), NOW());


-- ============================================
-- Insert Dummy Rooms (3 room types per hotel)
-- ============================================
-- Hotel 1: Grand Luxury Hotel Jakarta
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(1, 'Deluxe Room', 1200000.00, 2, 10, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(1, 'Executive Suite', 2250000.00, 3, 5, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(1, 'Family Room', 1800000.00, 4, 8, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 2: Bali Beach Resort
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(2, 'Deluxe Room', 1600000.00, 2, 12, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(2, 'Executive Suite', 3000000.00, 3, 6, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(2, 'Family Room', 2400000.00, 4, 9, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 3: Bandung Mountain Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(3, 'Deluxe Room', 640000.00, 2, 8, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(3, 'Executive Suite', 1200000.00, 3, 4, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(3, 'Family Room', 960000.00, 4, 7, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 4: Surabaya Business Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(4, 'Deluxe Room', 720000.00, 2, 11, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(4, 'Executive Suite', 1350000.00, 3, 5, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(4, 'Family Room', 1080000.00, 4, 8, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 5: Yogyakarta Heritage Inn
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(5, 'Deluxe Room', 400000.00, 2, 9, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(5, 'Executive Suite', 750000.00, 3, 4, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(5, 'Family Room', 600000.00, 4, 7, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 6: Lombok Paradise Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(6, 'Deluxe Room', 960000.00, 2, 10, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(6, 'Executive Suite', 1800000.00, 3, 5, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(6, 'Family Room', 1440000.00, 4, 8, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 7: Medan City Center Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(7, 'Deluxe Room', 360000.00, 2, 8, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(7, 'Executive Suite', 675000.00, 3, 4, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(7, 'Family Room', 540000.00, 4, 6, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 8: Makassar Waterfront Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(8, 'Deluxe Room', 760000.00, 2, 11, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(8, 'Executive Suite', 1425000.00, 3, 5, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(8, 'Family Room', 1140000.00, 4, 8, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 9: Semarang Colonial Hotel
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(9, 'Deluxe Room', 480000.00, 2, 9, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(9, 'Executive Suite', 900000.00, 3, 4, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(9, 'Family Room', 720000.00, 4, 7, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());

-- Hotel 10: Malang Highland Resort
INSERT INTO rooms (hotel_id, type, price, max_guests, available_rooms, image_url, description, is_active, created_at, updated_at) VALUES
(10, 'Deluxe Room', 600000.00, 2, 10, 'https://via.placeholder.com/800x600?text=Deluxe+Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan kota.', 1, NOW(), NOW()),
(10, 'Executive Suite', 1125000.00, 3, 5, 'https://via.placeholder.com/800x600?text=Executive+Suite', 'Suite mewah dengan ruang tamu terpisah dan fasilitas premium.', 1, NOW(), NOW()),
(10, 'Family Room', 900000.00, 4, 8, 'https://via.placeholder.com/800x600?text=Family+Room', 'Kamar luas cocok untuk keluarga dengan 2 tempat tidur.', 1, NOW(), NOW());
