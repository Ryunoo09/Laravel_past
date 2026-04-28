# Laravel 12 REST API Project

Proyek ini adalah implementasi RESTful API menggunakan **Laravel 12**. Proyek ini telah dilengkapi dengan arsitektur modern yang berfokus pada *best practices*, seperti implementasi `spatie/laravel-query-builder` untuk *filtering* dan *sorting* dinamis, serta standarisasi format respons JSON menggunakan Helper.

---

## 📁 Struktur Folder Utama

Untuk memudahkan navigasi, berikut adalah struktur file dan folder krusial yang mengatur logika aplikasi API ini:

- `app/Http/Controllers/PostController.php` - Menangani logika utama (CRUD). Menerapkan konsep *Thin Controller* dengan mendelegasikan kueri kompleks.
- `app/Helpers/ApiQuery.php` - Sentralisasi logika `Spatie\QueryBuilder`. Berfungsi mengatur filter, sorting, dan *include* relasi agar *query* tetap rapi.
- `app/Helpers/ApiResponse.php` - Mengatur standardisasi format *response* (Sukses/Error) dalam bentuk JSON agar konsisten di seluruh *endpoint*.
- `app/Http/Resources/` - Berisi `PostResource` dan `UserResource` yang bertugas membersihkan dan memformat bentuk data sebelum dikirimkan ke *client*.
- `routes/api.php` - Tempat pendaftaran rute `apiResource` untuk *endpoint* yang disediakan.

---

## 🚀 Cara Menjalankan Proyek (Pertama Kali Clone)

Jika Anda baru saja melakukan *clone* repositori ini, ikuti langkah-langkah berikut secara berurutan:

### 1. Instalasi Dependensi PHP
Laravel membutuhkan pustaka pihak ketiga agar bisa berjalan. Buka terminal (CMD/PowerShell/Git Bash) di dalam folder proyek ini dan jalankan:
```bash
composer install
```

### 2. Siapkan File Konfigurasi Environment (`.env`)
Salin template konfigurasi `.env.example` menjadi `.env`:

**Linux / Mac / Git Bash:**
```bash
cp .env.example .env
```
**Windows PowerShell / CMD:**
```cmd
copy .env.example .env
```

Buka file `.env` yang baru saja dibuat, lalu sesuaikan koneksi database Anda (biasanya di bagian ini):
```env
DB_CONNECTION=sqlite 
# Ubah menjadi mysql dan isi DB_DATABASE dll jika Anda menggunakan XAMPP/MySQL
```

### 3. Generate Application Key
Laravel membutuhkan *encryption key* agar sesi dan data aman. Jalankan:
```bash
php artisan key:generate
```

### 4. Migrasi Database (dan Seeder)
Buat struktur tabel di dalam database Anda menggunakan *migration*. Jika sistem menanyakan apakah ingin membuat database (untuk SQLite), ketik `yes`.
```bash
php artisan migrate
```
*(Tambahkan argumen `--seed` jika Anda memiliki Seeder dan ingin mengisi data dummy)*

### 5. Jalankan Server Lokal
Nyalakan server aplikasi Laravel:
```bash
php artisan serve
```
Aplikasi Anda kini sudah siap dan berjalan di: `http://127.0.0.1:8000`

---

## 📌 Endpoint API yang Tersedia

Karena proyek ini menggunakan Spatie QueryBuilder, *endpoint* GET menjadi sangat fleksibel. Gunakan URL di bawah ini melalui Postman, Insomnia, atau Browser:

*   **Mendapatkan Semua Data (Biasa):** 
    `http://127.0.0.1:8000/api/posts`
*   **Menyertakan Data Relasi User (`include`):** 
    `http://127.0.0.1:8000/api/posts?include=user`
*   **Melakukan Filter berdasarkan Status:** 
    `http://127.0.0.1:8000/api/posts?filter[status]=published`
*   **Melakukan Sorting Terbaru (`-` berarti descending):** 
    `http://127.0.0.1:8000/api/posts?sort=-created_at`
*   **Kombinasi Kompleks:** 
    `http://127.0.0.1:8000/api/posts?include=user&filter[status]=draft&sort=-id`

*(Gunakan method POST, PUT, DELETE pada alamat `/api/posts` untuk menambah, mengubah, atau menghapus data.)*
