# 📚 Dokumentasi Panduan: Sistem Inventaris "Toko Mas Wowo"

## 1. 🌟 Deskripsi Proyek
**Sistem Inventaris Toko Mas Wowo** adalah sebuah aplikasi web yang diinisiasi untuk mengkategorikan dan menata barang masuk beserta stok secara digital. Aplikasi ini mempermudah pemilik *(Mas Wowo)* maupun operator/kasir di kesehariannya supaya tidak perlu lagi menggunakan sistem penulisan tangan di buku tulis.

Pembaruan utama sistem ini mencakup perubahan **Tema Antarmuka Premium (Amber & Stone)** yang nyaman dilihat berjam-jam, memberikan kesan mewah khas kelontong modern atau toko emas, serta fitur otomatis untuk proteksi data dari kesalahan penghapusan.

---

## 2. ✨ Fitur-Fitur Utama
| Modul | Penjelasan Fitur | Status |
| :--- | :--- | :---: |
| **🔐 Sistem Autentikasi** | Laman muka hanya dapat diakses melalui login eksklusif yang diproteksi di-back oleh standar *Laravel Breeze*. | ✅ Selesai |
| **📦 Data Table Produk** | Inventaris dapat disortir, mencari produk (*live search*), dan paginasi yang dikalkulasi di depan layar tampa membuat *loading list* lama. | ✅ Selesai |
| **➕ Tambah Produk (*Create*)**| Penambahan Kode SKU Otomatis, Input Nama Panjang, Harga Kelipatan, serta pembatasan stok nol (*validation error block*). | ✅ Selesai |
| **📝 Ubah (*Edit*)** | Data terpopulasi pada setiap parameter ketika form Edit dibuka. Sangat meminimalisir kesalahan pengetikan ulang. | ✅ Selesai |
| **🗑️ Hapus (*Delete Modal*)** | Konfirmasi lapis kedua berbentuk *Popup/Modal* ketika mencoba menghapus produk untuk menghindari salah klik (*misclick*) atau terhapus tidak sengaja. | ✅ Selesai |
| **🗃️ Integrasi Seed DB** | Adanya sistem injeksi **50 dummy produk toko kelontong (Kopi, Teh, Sabun, Beras, dll.)** untuk kepentingan simulasi. | ✅ Selesai |

---

## 3. 🔑 Akun & Kredensial Login
Sistem dirancang untuk zero-configuration pertama (langsung bisa dijalankan dengan SQLite). Secara bawaan, pada saat sinkronasi database terdapat 1 akun Manajerial / Admin yang telah terdaftar agar Anda bisa masuk.

> Akses laman Login *(http://localhost:8000/login)*, dan isi:
> - **Email**: `admin@wowo.com`
> - **Password**: `password`

---

## 4. 🧰 Teknologi yang Digunakan
Keseluruhan teknologi yang membangun aplikasi modern ini adalah:
* **Backend Dasar**: PHP (versi 8.2 ke atas) & Framework **Laravel 11.x**.
* **Database Relasional**: **SQLite** (Tanpa Instalasi MySQL yang berat/merumitkan).
* **Basis Antarmuka (UI)**: **Tailwind CSS** dengan arsitektur **Vite** bundler.
* **Tabel Interaktif**: pustaka **jQuery DataTables** (Client-side Data rendering).
* **Interaktivitas (*Modals/Transitions*)**: **Alpine.js** bawaan Laravel-Blade.

---

## 5. 🧑‍💻 Cara Mengoperasikan (Lokal)
Karena aplikasi telah rampung, inilah panduan sederhana bagi operator (*atau developer*) jika ingin mendemonstrasikan sistem ini di masa mendatang menggunakan terminal Command Prompt (cmd) / Powershell lokal:

1. Buka folder/direktori target: `cd d:\apb_praktikum\2311102043_Pertemuan05`
2. (*Opsional*) Jika ini pertama kali dibuka di PC baru, *run* command berikut:
   ```bash
   composer install
   npm install
   npm run build
   php artisan migrate:fresh --seed
   ```
3. Mulai Virtual Server Laravel: 
   ```bash
   php artisan serve
   ```
4. Buka `http://localhost:8000` di Firefox/Chrome dan masuk.

---

## Preview Pertemuan 05

<hr>

<p align="center"><b>Page Login</b></p>
<p align="center">
  <img src="preview_login.png" width="500">
</p>

<hr>

<p align="center"><b>Page Produk</b></p>
<p align="center">
  <img src="preview_produk.png" width="500">
</p>

<hr>

<p align="center"><b>Page Add</b></p>
<p align="center">
  <img src="preview_add_produk.png" width="500">
</p>

<hr>

<p align="center"><b>Page Edit</b></p>
<p align="center">
  <img src="preview_edit_produk.png" width="500">
</p>

<hr>

<p align="center"><b>Page Delete</b></p>
<p align="center">
  <img src="preview_delete_produk.png" width="500">
</p>

<hr>
