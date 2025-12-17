# Vehease - Vehicle Management System

Sistem manajemen peminjaman kendaraan operasional perusahaan berbasis web.

## 🚀 Live Deployment

Aplikasi dapat diakses secara online melalui link berikut:
**[https://vehease.arpamuji.dev](https://vehease.arpamuji.dev)**

> **Akses Login:**
> Silakan tambahkan path **`/auth/login`** pada URL untuk masuk ke halaman login.
> Contoh: `https://vehease.arpamuji.dev/auth/login`

---

## 📝 Status Pengerjaan (Development Progress)

Saat ini pengembangan berfokus pada alur inti peminjaman kendaraan.

### ✅ Selesai (Completed)

- **Booking Request:** Staff sudah bisa mengajukan peminjaman kendaraan.
- **Vehicle Availability Logic:** Logika pengecekan ketersediaan kendaraan (filter tanggal & lokasi) sudah berjalan. Sistem otomatis menyembunyikan kendaraan yang sedang dipakai.
- **Authentication & Authorization:** Login dan pembagian hak akses berdasarkan role user.
- **Deployment:** Environment staging sudah live menggunakan Docker container.

### 🚧 Sedang Dikerjakan (In Progress)

- **Approval Workflow:** Mekanisme persetujuan berjenjang (Multi-level approval) oleh Manager/Branch Manager.

### ⏳ Belum Dikerjakan (Pending Features)

- Modul Maintenance Kendaraan.
- Pencatatan Bahan Bakar (Fuel Logs).
- Riwayat Perjalanan (Trip Logs).
- Dashboard Reporting & Analytics.

---

## 📂 Database Documentation

Dokumentasi lengkap mengenai struktur database dapat ditemukan di direktori **`/docs`**, yang mencakup:

- **ERD (Entity Relationship Diagram):** Visualisasi relasi antar tabel.
- **SQL:** Script schema database dan migrasi.
- **DBML:** Definisi struktur database.

---

## 🔑 Akun Demo (Credentials)

Gunakan akun berikut untuk melakukan testing pada aplikasi.
_(Default Password untuk semua akun: **password123**)_

### 1. Administrator

Akses penuh ke sistem, manajemen master data, dan bisa melakukan Create Booking.

- `admin1@vehease.com`
- `admin2@vehease.com`
- `admin3@vehease.com`
- `admin4@vehease.com`

### 2. Manager (Approver - Head Office)

Bertugas melakukan approval untuk request dari kantor pusat.

- `manager1@vehease.com`
- `manager2@vehease.com`

### 3. Branch Manager (Approver - Site/Cabang)

Bertugas melakukan approval untuk request dari lokasi cabang/site.

- `branchmanager1@vehease.com`
- `branchmanager2@vehease.com`
- `branchmanager3@vehease.com`
- `branchmanager4@vehease.com`

### 4. Staff (Requester)

User yang mengajukan peminjaman kendaraan.

- `staff1@vehease.com` s/d `staff9@vehease.com`

---

## 🛠 Tech Stack

- **Backend:** Laravel 11 (PHP 8.2+)
- **Frontend:** Vue.js 3 + Inertia.js
- **UI Component:** Shadcn Vue + Tailwind CSS
- **Database:** PostgreSQL
- **Infrastructure:** Docker & Nginx
