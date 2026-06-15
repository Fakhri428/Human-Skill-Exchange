# Human Skill Exchange API dengan RapiDoc

Project ini adalah implementasi praktikum Web Service berdasarkan `PRD_Human_Skill_Exchange_API.md`.
Strukturnya mengikuti contoh `RestApiRapidDocs-main`: PHP native, MySQL, Bearer Token, OpenAPI, dan dokumentasi interaktif menggunakan RapiDoc.

## Ringkasan

Human Skill Exchange API mempertemukan pengguna berdasarkan kontribusi yang dapat mereka berikan dan kebutuhan yang sedang mereka cari. Kontribusi dapat berupa skill, waktu, pengalaman, mentoring, bantuan project, atau kolaborasi kerja.

Alur utama MVP:

```text
Register/Login
Isi Profil
Tambah Skill, Need, dan Offer
Lihat Matching
Kirim Exchange Request
Accept/Reject
Update Progress
Konfirmasi Selesai oleh dua user
Review dan Rating
Hitung Reputasi
```

## Teknologi

- HTML
- CSS
- JavaScript
- PHP Native
- MySQL/MariaDB
- PDO
- OpenAPI 3.0
- RapiDoc
- XAMPP atau Laragon

## Struktur Folder

```text
HumanSkillExchangeAPI-main/
|
+-- index.html
+-- style.css
+-- app.js
+-- openapi.json
+-- database.sql
|
+-- api/
    +-- config.php
    +-- response.php
    +-- auth.php
    +-- plan_limits.php
    +-- register.php
    +-- login.php
    +-- logout.php
    +-- me.php
    +-- plans.php
    +-- subscription.php
    +-- profile.php
    +-- skills.php
    +-- needs.php
    +-- offers.php
    +-- exchange_types.php
    +-- matches.php
    +-- exchange_requests.php
    +-- exchange_progress.php
    +-- reviews.php
    +-- reputation.php
```

## Cara Instalasi

1. Pindahkan folder `HumanSkillExchangeAPI-main` ke folder web server lokal.

   Untuk XAMPP:

   ```text
   C:/xampp/htdocs/HumanSkillExchangeAPI-main
   ```

   Untuk Laragon:

   ```text
   C:/laragon/www/HumanSkillExchangeAPI-main
   ```

2. Aktifkan Apache dan MySQL.

3. Buka phpMyAdmin, lalu import file:

   ```text
   database.sql
   ```

4. Sesuaikan konfigurasi database jika diperlukan di:

   ```text
   api/config.php
   ```

   Default konfigurasi:

   ```php
   $host = "localhost";
   $dbname = "human_skill_exchange";
   $username = "root";
   $password = "root";
   ```

   Jika MySQL Anda tidak memakai password, ubah `$password` menjadi string kosong.

5. Buka project di browser:

   ```text
   http://localhost/HumanSkillExchangeAPI-main/
   ```

## Akun Contoh

Semua akun contoh memakai password:

```text
password123
```

| Nama | Email | Token |
|---|---|---|
| Fakhri | `fakhri@example.com` | `fakhri-token-123` |
| Raka | `raka@example.com` | `raka-token-123` |
| Admin | `admin@hse.test` | `admin-token-123` |

Gunakan token pada header:

```http
Authorization: Bearer fakhri-token-123
```

## Endpoint Utama

| Method | Endpoint | Fungsi | Token |
|---|---|---|---|
| POST | `/api/register.php` | Register user baru | Tidak |
| POST | `/api/login.php` | Login dan mendapatkan token | Tidak |
| POST | `/api/logout.php` | Logout user login | Ya |
| GET | `/api/me.php` | Melihat user login | Ya |
| GET | `/api/plans.php` | Melihat paket Gratis, Pro, Pro Max | Tidak |
| GET | `/api/subscription.php` | Melihat paket aktif | Ya |
| POST | `/api/subscription.php` | Mengaktifkan paket | Ya |
| PATCH | `/api/subscription.php` | Membatalkan subscription | Ya |
| GET | `/api/profile.php` | Melihat profil login | Ya |
| POST/PUT | `/api/profile.php` | Membuat atau memperbarui profil | Ya |
| GET/POST/PUT/DELETE | `/api/skills.php` | CRUD skill | Ya |
| GET/POST/PUT/DELETE | `/api/needs.php` | CRUD need | Ya |
| GET/POST/PUT/DELETE | `/api/offers.php` | CRUD offer | Ya |
| GET | `/api/exchange_types.php` | Melihat jenis exchange | Tidak |
| GET | `/api/matches.php` | Rule-based matching | Ya |
| GET/POST/PATCH | `/api/exchange_requests.php` | Exchange request dan status | Ya |
| GET/POST/PUT/DELETE | `/api/exchange_progress.php` | Progress exchange | Ya |
| GET/POST | `/api/reviews.php` | Review dan rating | Ya |
| GET | `/api/reputation.php` | Menghitung reputasi user | Ya |

## Contoh Request

### Login

```http
POST /api/login.php
Content-Type: application/json
```

```json
{
  "email": "fakhri@example.com",
  "password": "password123"
}
```

### Membuat Offer

```http
POST /api/offers.php
Content-Type: application/json
Authorization: Bearer fakhri-token-123
```

```json
{
  "title": "Saya bisa bantu membuat REST API Laravel",
  "type": "skill",
  "category": "Programming",
  "description": "Saya bisa bantu API login, CRUD, dan dokumentasi Postman.",
  "exchange_expectation": "Saya membutuhkan bantuan desain UI dashboard.",
  "available_duration": "4 jam per minggu"
}
```

### Melihat Matching

```http
GET /api/matches.php
Authorization: Bearer fakhri-token-123
```

### Mengirim Exchange Request

```http
POST /api/exchange_requests.php
Content-Type: application/json
Authorization: Bearer fakhri-token-123
```

```json
{
  "to_user_id": 2,
  "offer_id": 1,
  "need_id": 2,
  "message": "Halo, saya bisa bantu Laravel REST API dan butuh bantuan UI Design."
}
```

### Accept atau Reject Request

```http
PATCH /api/exchange_requests.php?id=1&action=status
Content-Type: application/json
Authorization: Bearer raka-token-123
```

```json
{
  "status": "accepted"
}
```

### Konfirmasi Selesai

```http
PATCH /api/exchange_requests.php?id=1&action=complete
Authorization: Bearer fakhri-token-123
```

Exchange menjadi `completed` setelah kedua user menjalankan endpoint complete.

### Review

```http
POST /api/reviews.php
Content-Type: application/json
Authorization: Bearer fakhri-token-123
```

```json
{
  "exchange_request_id": 1,
  "reviewed_user_id": 2,
  "rating": 5,
  "comment": "Raka komunikatif dan desain UI-nya rapi."
}
```

## Paket dan Limit

| Fitur | Gratis | Pro | Pro Max |
|---|---:|---:|---:|
| Skill | 3 | 10 | Unlimited |
| Need | 3 | 10 | Unlimited |
| Offer | 2 | 10 | Unlimited |
| Exchange request per bulan | 5 | 30 | Unlimited |

Limit ini sudah diterapkan pada endpoint `skills.php`, `needs.php`, `offers.php`, dan `exchange_requests.php`.

## Catatan Keamanan

Project ini dibuat untuk praktikum. Password sudah memakai `password_hash()` dan `password_verify()`, tetapi implementasi token masih sederhana agar mudah dipahami. Untuk produksi, gunakan JWT atau token personal access yang memiliki masa berlaku, HTTPS, rate limiting, audit log, dan role-based access control yang lebih lengkap.

## Dokumentasi RapiDoc

File `openapi.json` dibaca oleh halaman `index.html` melalui RapiDoc. Gunakan tombol Authorize di RapiDoc, lalu masukkan token contoh:

```text
fakhri-token-123
```

Setelah itu endpoint yang membutuhkan token dapat dicoba langsung dari browser.
