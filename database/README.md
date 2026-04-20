# Database Setup - Hotel Reservation Web

## Konfigurasi MySQL

### 1. Buat Database dan Import Schema

```bash
# Login ke MySQL
mysql -u root -p

# Atau jalankan langsung dari command line
mysql -u root -p < database/schema.sql
```

### 2. Import Data Dummy

```bash
mysql -u root -p < database/seed_data.sql
```

### 3. Atau Jalankan Sekaligus

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed_data.sql
```

## Konfigurasi .env

File `.env` sudah dikonfigurasi dengan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hotel_reserv_web
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan:** Sesuaikan `DB_PASSWORD` dengan password MySQL Anda.

## Alternatif: Menggunakan Laravel Migration & Seeder

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder
php artisan db:seed

# Atau jalankan seeder spesifik
php artisan db:seed --class=BrandSeeder
php artisan db:seed --class=DestinationSeeder
php artisan db:seed --class=HotelSeeder
```

## Data Dummy

### Users (5 users)
Semua user memiliki password: **password**

| Name | Email | Email Verified |
|------|-------|----------------|
| Test User | test@example.com | ✓ |
| Admin User | admin@hotel-reserv.com | ✓ |
| John Doe | john.doe@example.com | ✓ |
| Jane Smith | jane.smith@example.com | ✗ |
| Bob Wilson | bob.wilson@example.com | ✓ |

### Hotels (10 hotels)
- Grand Luxury Hotel Jakarta (5⭐)
- Bali Beach Resort (5⭐)
- Bandung Mountain Hotel (4⭐)
- Surabaya Business Hotel (4⭐)
- Yogyakarta Heritage Inn (3⭐)
- Lombok Paradise Hotel (4⭐)
- Medan City Center Hotel (3⭐)
- Makassar Waterfront Hotel (4⭐)
- Semarang Colonial Hotel (3⭐)
- Malang Highland Resort (4⭐)

### Rooms (30 rooms - 3 types per hotel)
- Deluxe Room
- Executive Suite
- Family Room

### Destinations (12 destinations)
- Jakarta, Bali, Yogyakarta, Bandung (Popular)
- Surabaya, Lombok, Medan, Makassar
- Semarang, Malang, Raja Ampat, Labuan Bajo

### Brands (10 brands)
- Marriott Hotels, Hilton Hotels, Accor Hotels
- InterContinental Hotels, Hyatt Hotels
- Four Seasons, Shangri-La Hotels
- Aston Hotels, Santika Hotels, Favehotel

## Verifikasi

```bash
# Test koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
```
