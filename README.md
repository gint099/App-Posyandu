# 🏥 SISTEM INFORMASI POSYANDU

Sistem informasi untuk mengelola data kesehatan balita di Posyandu dengan fitur monitoring, pencatatan pemeriksaan, imunisasi, dan pelaporan.

---

## 📋 **FITUR UTAMA**

### **1. Fitur Publik (Tanpa Login)**
- ✅ Pencarian data pasien berdasarkan NIK
- ✅ Melihat riwayat pemeriksaan lengkap
- ✅ Melihat riwayat imunisasi
- ✅ Grafik perkembangan berat & tinggi badan
- ✅ Melihat jadwal pelayanan posyandu
- ✅ Informasi posyandu per RW

### **2. Fitur Kader**
- ✅ Dashboard dengan statistik
- ✅ CRUD data pasien (balita)
- ✅ Input hasil pemeriksaan (BB, TB, LK, Vitamin, Status Gizi)
- ✅ Input data imunisasi
- ✅ Edit & update data
- ✅ Melihat riwayat lengkap per pasien
- ✅ Filter & pencarian data

### **3. Fitur Admin Kelurahan**
- ✅ Dashboard monitoring seluruh posyandu
- ✅ CRUD data kader
- ✅ Reset password kader
- ✅ CRUD data posyandu
- ✅ CRUD jadwal pelayanan
- ✅ Monitoring data pasien (semua posyandu)
- ✅ Laporan bulanan
- ✅ Rekap per RW dengan grafik
- ✅ Export/cetak laporan

---

## 🛠️ **TEKNOLOGI YANG DIGUNAKAN**

- **Backend:** Laravel 11
- **Frontend:** Blade Template Engine, Bootstrap 5
- **Database:** MySQL
- **Chart:** Chart.js
- **Icons:** Font Awesome 6
- **Authentication:** Laravel Built-in Auth

---

## 📦 **INSTALASI**

### **1. Clone/Download Project**

```bash
git clone [repository-url]
cd posyandu-app

### **2. Install Dependencies**

```bash
composer install
npm install
```

### **3. Konfigurasi Environment**

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`:
```env
DB_DATABASE=posyandu_db
DB_USERNAME=root
DB_PASSWORD=
```

### **4. Buat Database**

```sql
CREATE DATABASE posyandu_db;
```

### **5. Migrasi & Seeder**

```bash
php artisan migrate
php artisan db:seed
```

### **6. Jalankan Server**

```bash
php artisan serve
```

Akses: **http://localhost:8000**

---

## 👤 **AKUN DEFAULT**

### **Admin Kelurahan**
- Email: `admin@posyandu.com`
- Password: `admin123`

### **Kader Posyandu Melati (RW 01)**
- Email: `kader1@posyandu.com`
- Password: `kader123`

### **Kader Posyandu Mawar (RW 02)**
- Email: `kader2@posyandu.com`
- Password: `kader123`

### **Testing Pencarian NIK**
- NIK: `3201012020000001` (Budi Santoso)
- NIK: `3201012021000002` (Ani Lestari)

---

## 📂 **STRUKTUR DATABASE**

### **Tabel Utama:**
1. `users` - Data admin & kader
2. `posyandus` - Data posyandu per RW
3. `pasiens` - Data balita/pasien
4. `pemeriksaans` - Riwayat pemeriksaan
5. `imunisasis` - Riwayat imunisasi
6. `jadwals` - Jadwal pelayanan

### **Relasi:**
- 1 Posyandu → Many Pasien
- 1 Posyandu → Many User (Kader)
- 1 Pasien → Many Pemeriksaan
- 1 Pasien → Many Imunisasi
- 1 User → Many Pemeriksaan (yang input)

---

## 🚀 **ROUTE LIST**

### **Public Routes**
```
GET  /                      - Homepage
GET  /cari-pasien          - Form pencarian NIK
POST /cari-pasien          - Proses pencarian
GET  /pasien/{id}          - Detail pasien
GET  /jadwal               - Daftar jadwal
GET  /posyandu             - Daftar posyandu
```

### **Kader Routes** (Prefix: `/kader`)
```
GET  /dashboard            - Dashboard kader
GET  /pasien               - Daftar pasien
GET  /pasien/create        - Form tambah pasien
POST /pasien               - Simpan pasien
GET  /pasien/{id}          - Detail pasien
GET  /pasien/{id}/edit     - Form edit pasien
PUT  /pasien/{id}          - Update pasien
DELETE /pasien/{id}        - Hapus pasien

GET  /pemeriksaan          - Daftar pemeriksaan
GET  /pemeriksaan/create   - Form input pemeriksaan
POST /pemeriksaan          - Simpan pemeriksaan
GET  /pemeriksaan/{id}/edit - Form edit pemeriksaan
PUT  /pemeriksaan/{id}     - Update pemeriksaan
DELETE /pemeriksaan/{id}   - Hapus pemeriksaan

GET  /imunisasi/create     - Form input imunisasi
POST /imunisasi            - Simpan imunisasi
GET  /imunisasi/{id}/edit  - Form edit imunisasi
PUT  /imunisasi/{id}       - Update imunisasi
DELETE /imunisasi/{id}     - Hapus imunisasi
```

### **Admin Routes** (Prefix: `/admin`)
```
GET  /dashboard            - Dashboard admin
GET  /kader                - Daftar kader
GET  /kader/create         - Form tambah kader
POST /kader                - Simpan kader
GET  /kader/{id}           - Detail kader
GET  /kader/{id}/edit      - Form edit kader
PUT  /kader/{id}           - Update kader
DELETE /kader/{id}         - Hapus kader
POST /kader/{id}/reset-password - Reset password kader

GET  /posyandu             - Daftar posyandu
GET  /posyandu/create      - Form tambah posyandu
POST /posyandu             - Simpan posyandu
GET  /posyandu/{id}        - Detail posyandu
GET  /posyandu/{id}/edit   - Form edit posyandu
PUT  /posyandu/{id}        - Update posyandu
DELETE /posyandu/{id}      - Hapus posyandu

GET  /jadwal               - Daftar jadwal
GET  /jadwal/create        - Form tambah jadwal
POST /jadwal               - Simpan jadwal
GET  /jadwal/{id}/edit     - Form edit jadwal
PUT  /jadwal/{id}          - Update jadwal
DELETE /jadwal/{id}        - Hapus jadwal

GET  /pasien               - Daftar semua pasien
GET  /pasien/{id}          - Detail pasien

GET  /laporan/bulanan      - Laporan bulanan
GET  /laporan/rekap-rw     - Rekap per RW
```

---

## 🎨 **DESAIN & UI**

- **Warna Utama:** Hijau (#4CAF50) - kesehatan
- **Warna Sekunder:** Biru (#2196F3) - kepercayaan
- **Typography:** Segoe UI, modern & clean
- **Icons:** Font Awesome 6
- **Responsive:** Mobile-first design
- **Chart:** Chart.js untuk visualisasi data

---

## 📱 **RESPONSIVE DESIGN**

Sistem fully responsive untuk:
- 📱 Mobile (< 768px)
- 📱 Tablet (768px - 1024px)
- 💻 Desktop (> 1024px)

---

## 🔒 **KEAMANAN**

- ✅ Password hashing (bcrypt)
- ✅ CSRF Protection
- ✅ Role-based access control
- ✅ Middleware authentication
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)

---

## 📊 **FITUR GRAFIK**

Menggunakan Chart.js untuk:
- Grafik perkembangan berat badan
- Grafik perkembangan tinggi badan
- Grafik distribusi pasien per RW
- Visualisasi status gizi

---

## 🐛 **TROUBLESHOOTING**

### **Error: SQLSTATE[HY000] [1045]**
```bash
# Cek kredensial database di .env
DB_USERNAME=root
DB_PASSWORD=
```

### **Error: Class 'X' not found**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
```

### **Error: Vite manifest not found**
```bash
npm install
npm run build
```

---

## 📞 **KONTAK & SUPPORT**

Untuk pertanyaan dan dukungan:
- Email: support@posyandu.com
- GitHub Issues: [link]

---

## 📄 **LICENSE**

MIT License - Free to use

---

## 👨‍💻 **DEVELOPER**

Developed with ❤️ for better health monitoring

**Version:** 1.0.0  
**Last Updated:** 2024
```

---

## ✅ **CHECKLIST TAHAP 6 - COMPLETE**

- ✅ Homepage publik dengan info & jadwal terdekat
- ✅ Halaman pencarian NIK
- ✅ Detail pasien untuk publik (dengan grafik)
- ✅ Halaman jadwal pelayanan
- ✅ Halaman daftar posyandu
- ✅ Navbar publik dengan menu lengkap
- ✅ Footer informatif
- ✅ Responsive design
- ✅ Chart.js untuk grafik perkembangan
- ✅ README.md dokumentasi lengkap

---

## 🎉 **SISTEM POSYANDU - COMPLETE!**

### **📊 RINGKASAN LENGKAP:**

**Total Fitur yang Dibuat:**
- ✅ 3 Role System (Publik, Kader, Admin)
- ✅ 6 Tabel Database
- ✅ 40+ Halaman/View
- ✅ 15+ Controllers
- ✅ 6 Models dengan Relasi
- ✅ Authentication & Authorization
- ✅ CRUD Complete untuk semua entitas
- ✅ Laporan & Statistik
- ✅ Grafik Visualisasi Data
- ✅ Responsive Design
- ✅ Print/Export Laporan

**Teknologi:**
- Laravel 11 ✅
- Blade Template ✅
- Bootstrap 5 ✅
- MySQL ✅
- Chart.js ✅
- Font Awesome ✅

---

## 🚀 **QUICK START GUIDE**

```bash
# 1. Install dependencies
composer install

# 2. Setup environment
cp .env.example .env
php artisan key:generate

# 3. Create database
mysql -u root -e "CREATE DATABASE posyandu_db"

# 4. Migrate & Seed
php artisan migrate --seed

# 5. Run server
php artisan serve

# 6. Access
http://localhost:8000

# Login:
# Admin: admin@posyandu.com / admin123
# Kader: kader1@posyandu.com / kader123
```

---

## 🎯 **FITUR BONUS (Opsional untuk Pengembangan)**

Jika ingin dikembangkan lebih lanjut:
- 📧 Email notification untuk jadwal
- 📱 SMS reminder untuk orang tua
- 📊 Export Excel untuk laporan
- 🗺️ Google Maps integration
- 📷 Upload foto pasien
- 💬 WhatsApp integration
- 📈 Dashboard analytics lebih detail
- 🔔 Push notification
- 📱 Mobile App (Flutter/React Native)

---

## ❓ **FINAL STATUS**

**Apakah ada yang ingin ditambahkan atau diperbaiki?**

**Pilih:**

**A.** ✅ **Perfect! Sistem sudah lengkap** - Saya akan buatkan summary & checklist final

**B.** 🔧 **Ada yang mau ditambah** - Sebutkan fitur apa

**C.** 📝 **Minta dokumentasi tambahan** - Tutorial deployment, dll

**D.** 🐛 **Ada bug/error** - Sebutkan errornya

**Silakan konfirmasi! 🎉**
