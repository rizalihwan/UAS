# 📚 Dokumentasi SIAKAD - Sistem Informasi Akademik

## 📋 Ringkasan Perubahan

Aplikasi telah ditingkatkan dengan fitur-fitur baru dan peningkatan UI/UX yang signifikan.

---

## ✅ Yang Telah Diimplementasikan

### 1. **Tabel Matakuliah Baru**
   - Field: `id_matkul`, `nama_matkul`, `semester`, `sks`
   - Sudah diintegrasikan di database dengan data dummy

### 2. **CRUD Operasi Matakuliah**
   - ✅ **Create**: Tambah matakuliah baru
   - ✅ **Read**: Lihat daftar semua matakuliah
   - ✅ **Update**: Edit data matakuliah
   - ✅ **Delete**: Hapus matakuliah dengan konfirmasi

### 3. **Halaman Data Mahasiswa**
   - Menampilkan daftar semua mahasiswa terdaftar
   - Indikator mahasiswa yang sedang login (Anda)
   - Tabel interaktif dengan sorting

### 4. **Navigasi Menu Utama**
   - Navigation bar di semua halaman setelah login
   - Link akses ke: Dashboard, Data Mahasiswa, Matakuliah
   - Indikator halaman aktif
   - Tombol logout yang mudah diakses

### 5. **Peningkatan UI/UX**
   - ✅ Gradient background yang menarik
   - ✅ Card-based layout dengan shadow effect
   - ✅ Responsive design untuk mobile
   - ✅ Smooth transitions dan animations
   - ✅ Color-coded buttons (primary, secondary, danger)
   - ✅ Alert messages dengan auto-close
   - ✅ Form validation dengan visual feedback

### 6. **JavaScript Interaktif**
   - Form validation sebelum submit
   - Auto-close alert messages (5 detik)
   - Loading state pada button submit
   - Konfirmasi delete dengan modal
   - Active nav link detection
   - Smooth scrolling untuk anchor links

---

## 🗂️ Struktur File

```
php_tugas_web_based/
├── config.php              # Konfigurasi database
├── index.php              # Halaman login
├── login.php              # Handler proses login
├── logout.php             # Handler proses logout
├── dashboard.php          # Halaman utama setelah login
├── mahasiswa.php          # Halaman data mahasiswa (NEW)
├── matakuliah.php         # CRUD matakuliah (NEW)
├── setup.php              # Setup database (UPDATED)
├── style.css              # Styling (UPDATED)
├── main.js                # JavaScript interaktif (NEW)
└── README.md              # Dokumentasi ini
```

---

## 🚀 Cara Menggunakan

### 1. **Setup Database**
```bash
# Akses file setup.php di browser
http://localhost/php_tugas_web_based/setup.php
# Database dan tabel akan dibuat otomatis
```

### 2. **Login**
- Buka `http://localhost/php_tugas_web_based/`
- Gunakan credential demo:
  - **Username**: `rizal` atau `ihwan`
  - **Password**: `password123`

### 3. **Navigasi Aplikasi**
- **Dashboard**: Ringkasan profil dan akses cepat
- **Data Mahasiswa**: Lihat semua mahasiswa terdaftar
- **Matakuliah**: Kelola data mata kuliah
  - Klik "Tambah Matakuliah" untuk menambah
  - Klik "Edit" untuk mengubah data
  - Klik "Hapus" untuk menghapus (dengan konfirmasi)

---

## 📊 Database Schema

### Tabel: `mahasiswa`
```sql
CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(100)
);
```

### Tabel: `matakuliah` (BARU)
```sql
CREATE TABLE matakuliah (
    id_matkul INT AUTO_INCREMENT PRIMARY KEY,
    nama_matkul VARCHAR(100) NOT NULL,
    semester INT NOT NULL,
    sks INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🎨 Desain UI

### Fitur Design
- **Glassmorphism**: Effect blur dengan transparency
- **Gradient**: Warna gradien yang menarik dan modern
- **Responsive**: Mobile-friendly design
- **Dark Mode Friendly**: Kontras warna yang bagus

### Color Palette
- Primary: `#667eea` - `#764ba2` (Purple)
- Success: `#4CAF50` (Green)
- Danger: `#F1576C` (Red)
- Info: `#0093E9` - `#80D0C7` (Blue)

---

## 🔒 Keamanan

### Implementasi Keamanan
- ✅ Password hashing dengan `password_hash()`
- ✅ Password verification dengan `password_verify()`
- ✅ Session-based authentication
- ✅ SQL Injection prevention dengan PDO prepared statements
- ✅ XSS prevention dengan `htmlspecialchars()`
- ✅ CSRF protection (implicit via session)

---

## 📱 Fitur Responsif

Aplikasi mendukung tampilan di berbagai ukuran layar:
- ✅ Desktop (1200px+)
- ✅ Tablet (768px - 1199px)
- ✅ Mobile (< 768px)

---

## 🛠️ Tech Stack

- **Backend**: PHP 8+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Styling**: CSS3 (Gradients, Flexbox, Grid)
- **Server**: Apache (XAMPP)

---

## 📝 Query Contoh

### Tambah Matakuliah
```php
$stmt = $pdo->prepare("INSERT INTO matakuliah (nama_matkul, semester, sks) VALUES (?, ?, ?)");
$stmt->execute([$nama_matkul, $semester, $sks]);
```

### Lihat Semua Matakuliah
```php
$stmt = $pdo->query("SELECT * FROM matakuliah ORDER BY semester, id_matkul");
$matakuliah = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

### Update Matakuliah
```php
$stmt = $pdo->prepare("UPDATE matakuliah SET nama_matkul = ?, semester = ?, sks = ? WHERE id_matkul = ?");
$stmt->execute([$nama_matkul, $semester, $sks, $id_matkul]);
```

### Hapus Matakuliah
```php
$stmt = $pdo->prepare("DELETE FROM matakuliah WHERE id_matkul = ?");
$stmt->execute([$id_matkul]);
```

---

## 🎯 Flow Aplikasi

```
┌─────────────────┐
│   index.php     │ ← Landing page
│   (Login)       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  login.php      │ ← Process login
│  (Validasi)     │
└────────┬────────┘
         │
         ▼
┌─────────────────────────┐
│   dashboard.php         │ ← Dashboard utama
│   (Setelah login)       │
└──┬────────┬─────────┬───┘
   │        │         │
   ▼        ▼         ▼
┌──────┐ ┌───────┐ ┌──────────┐
│ Data │ │Mata-  │ │ Logout   │
│Maha- │ │kuliah │ │          │
│siswa │ │ CRUD  │ │          │
└──────┘ └───────┘ └──────────┘
```

---

## 📞 Support & Bug Report

Jika menemukan bug atau ada pertanyaan, silakan:
1. Periksa kembali format data input
2. Pastikan database sudah di-setup dengan benar
3. Periksa error logs di browser console (F12)

---

## 📄 License

Aplikasi ini dibuat untuk keperluan educational purposes.

---

**Last Updated**: 2026-05-02
