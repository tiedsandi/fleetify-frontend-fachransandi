## 🚗 Fleetify Frontend - Fachransandi

### 📌 Deskripsi Singkat

Sebuah perusahaan Multinasional memiliki jumlah karyawan diatas 50 karyawan, dan memiliki berbagai macam Divisi atau departemen didalamnya. Karena banyaknya karyawan untuk dikelola, perusahaan membutuhkan Sistem untuk Absensi guna mencatat serta mengevaluasi kedisiplinan karyawan secara sistematis.

---

### ⚙️ Teknologi yang Digunakan

-   Laravel (Blade Template Engine)
-   jQuery + AJAX
-   Axios
-   Bootstrap 5
-   DataTables
-   SweetAlert2

---

### 🚀 Cara Instalasi

1. **Clone repositori ini**

    ```bash
    git clone https://github.com/tiedsandi/fleetify-frontend-fachransandi
    cd fleetify-frontend-fachransandi
    ```

2. **Install dependency Laravel**

    ```bash
    composer install
    ```

3. **Salin file .env dan generate key**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Jalankan server Laravel**

    ```bash
    php artisan serve
    ```

5. **Pastikan REST API eksternal berjalan di** `http://localhost:8080`
   (Aplikasi ini mengambil data dari backend di port tersebut)

---

### 🧭 Route Halaman (Laravel Blade)

| Route          | Halaman Blade        |
| -------------- | -------------------- |
| `/`            | Absensi              |
| `/departments` | Manajemen Departemen |
| `/employees`   | Manajemen Karyawan   |
| `/absensi-log` | Riwayat Absensi      |

---

### 🧪 Catatan Teknis

-   Pengambilan dan pengiriman data ke API dilakukan dengan **AJAX jQuery** (untuk tabel & form) dan **Axios** (untuk absensi real-time).
-   Tabel-tabel menggunakan **DataTables** untuk fitur sorting, search, dan paginasi otomatis.
-   Tidak ada refresh halaman, semua proses dilakukan via JavaScript dinamis.
-   Validasi & feedback ke pengguna ditampilkan menggunakan **SweetAlert2**.

---

### 📂 Struktur Direktori Utama (Blade View)

```
resources/views/
├── absensi.blade.php
├── departments.blade.php
├── employee.blade.php
└── absensi-log.blade.php
```

---
