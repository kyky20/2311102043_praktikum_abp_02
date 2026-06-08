# To-Do Provider FCM

Aplikasi Flutter sederhana untuk praktikum Provider dan Firebase Cloud Messaging.

## Fitur

- Menampilkan daftar tugas sederhana.
- Menambah tugas menggunakan state management Provider.
- Memilih tugas dengan checkbox.
- Menghapus tugas yang dipilih.
- Menghapus seluruh tugas.
- Menampilkan status Firebase Cloud Messaging.
- Menampilkan token FCM dan notifikasi terakhir yang diterima.

## Firebase

Aplikasi sudah dikonfigurasi dengan Firebase Android menggunakan package:

```text
com.example.todo_2311102043
```

File konfigurasi Firebase berada di:

```text
android/app/google-services.json
```

## Hasil Screenshot

### 1. Tampilan Daftar Tugas

![Tampilan daftar tugas](screenshots/01_tampilan_daftar_tugas.png)

### 2. Proses Penambahan Tugas

![Proses penambahan tugas](screenshots/02_proses_tambah_tugas.png)

### 3. Notifikasi FCM Berhasil Diterima

![Notifikasi FCM berhasil diterima](screenshots/03_notifikasi_fcm_berhasil.png)

## Pengujian

Pengujian dilakukan dengan menjalankan aplikasi pada Android Emulator, menambahkan tugas melalui form, memilih tugas dari daftar, dan mengirim notifikasi FCM dari Firebase Console atau Postman ke token FCM aplikasi.

## Build

```bash
flutter pub get
flutter run
```
