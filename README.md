# FlipPlay REST API

REST API untuk mengelola media FlipPlay dan koleksi media milik pengguna. Dibuat dengan Laravel 12.

## Menjalankan project

```bash
composer install
copy .env.example .env
php artisan key:generate
```

Project ini menggunakan MySQL dari Laragon. Nyalakan MySQL di Laragon, lalu buat database bernama `flipplay_api` (misalnya lewat HeidiSQL atau phpMyAdmin). `.env.example` sudah memakai pengaturan standar Laragon (`root` tanpa password); sesuaikan `.env` jika konfigurasi MySQL-mu berbeda.

Setelah database dibuat, jalankan migration dan server:

```bash
php artisan migrate
php artisan serve
```

Data uji yang sebelumnya tersimpan di SQLite tidak otomatis dipindahkan. Tambahkan ulang data pengguna dan media melalui API/Postman setelah tersambung ke MySQL.

Base URL lokal: `http://127.0.0.1:8000/api`. Request dengan body harus memakai header `Accept: application/json` dan `Content-Type: application/json`.

## Endpoint

| Method | Endpoint | Fungsi |
| --- | --- | --- |
| GET | `/media` | Daftar media; filter judul dengan `?search=batman` |
| POST | `/media` | Membuat media |
| GET | `/media/{id}` | Detail media dan pengguna yang menyimpannya |
| PUT/PATCH | `/media/{id}` | Mengubah media |
| DELETE | `/media/{id}` | Menghapus media |
| GET | `/users` | Daftar pengguna dan koleksi mereka |
| POST | `/users` | Membuat pengguna |
| GET | `/users/{id}` | Detail pengguna dan koleksinya |
| GET | `/users/{id}/media` | Melihat koleksi pengguna |
| POST | `/users/{id}/media/{mediaId}` | Menambahkan media ke koleksi (409 jika sudah ada) |
| DELETE | `/users/{id}/media/{mediaId}` | Menghapus media dari koleksi |

Contoh body untuk membuat media:

```json
{
  "title": "Interstellar",
  "type": "Movie",
  "genre": "Sci-Fi",
  "year": 2014,
  "duration": 169
}
```

Contoh body untuk membuat pengguna:

```json
{
  "name": "Khairus",
  "email": "khairus@example.com",
  "password": "password123"
}
```

Validasi gagal akan mengembalikan HTTP 422 beserta rincian kesalahan. Judul media dan email pengguna harus unik.

## Urutan mencoba di Postman

1. `POST /api/users` untuk membuat pengguna, lalu catat `data.id` dari respons.
2. `POST /api/media` untuk membuat media, lalu catat `data.id`.
3. `POST /api/users/{userId}/media/{mediaId}` untuk memasukkan media ke koleksi.
4. `GET /api/users/{userId}/media` untuk melihat koleksi dan relasinya.
5. Kirim lagi request langkah 3 untuk melihat respons duplikat `409`.
6. `DELETE /api/users/{userId}/media/{mediaId}` untuk menghapus media dari koleksi.
7. Coba `POST /api/media` dengan `title` kosong atau judul yang sama untuk melihat validasi `422`.

Semua endpoint tercatat dengan `php artisan route:list --path=api`.
