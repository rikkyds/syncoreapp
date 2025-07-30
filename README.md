# SyncoreApp - Sistem Manajemen Karyawan

Aplikasi manajemen karyawan berbasis web yang dibangun dengan Laravel 10 untuk mengelola data karyawan, absensi, gaji, dokumen, dan berbagai aspek HR lainnya.

## 🚀 Fitur Utama

### Manajemen Master Data
- **Perusahaan**: Kelola data perusahaan
- **Kantor Cabang**: Manajemen kantor cabang per perusahaan
- **Unit Kerja**: Organisasi unit kerja per kantor cabang
- **Jabatan**: Master data jabatan/posisi
- **Pengguna & Role**: Sistem autentikasi dengan role-based access

### Manajemen Karyawan
- **Data Karyawan**: Profil lengkap karyawan dengan foto dan dokumen
- **Informasi Pribadi**: Data personal, kontak, dan keluarga
- **Informasi Kepegawaian**: Status, jabatan, unit kerja
- **Dokumen**: Upload dan manajemen dokumen karyawan

### Sistem Absensi
- **Absensi Harian**: Pencatatan kehadiran dengan GPS tracking
- **Jadwal Shift**: Manajemen shift kerja karyawan
- **Perhitungan Otomatis**: Jam kerja, lembur, keterlambatan
- **Verifikasi Supervisor**: Sistem approval absensi

### Manajemen Gaji
- **Slip Gaji**: Generate slip gaji bulanan
- **Komponen Gaji**: Gaji pokok, tunjangan, potongan
- **Perhitungan Lembur**: Otomatis berdasarkan jam kerja
- **Riwayat Pembayaran**: Tracking pembayaran gaji

### Sistem Cuti & Izin
- **Pengajuan Cuti**: Form pengajuan dengan approval workflow
- **Jenis Cuti**: Tahunan, sakit, melahirkan, dll
- **Saldo Cuti**: Tracking sisa cuti karyawan
- **Riwayat Cuti**: Laporan cuti per karyawan

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **File Upload**: Laravel Storage
- **JavaScript**: Vanilla JS untuk interaktivitas

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7
- Web Server (Apache/Nginx)

## 🔧 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/syncoreapp.git
   cd syncoreapp
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=syncoreapp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Run Application**
   ```bash
   php artisan serve
   ```

## 👤 Default Login

Setelah seeding, gunakan akun berikut untuk login:

- **Email**: admin@example.com
- **Password**: password
- **Role**: Administrator

## 📁 Struktur Project

```
syncoreapp/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   ├── Console/Commands/    # Artisan Commands
│   └── Http/Middleware/     # Custom Middleware
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   ├── views/              # Blade Templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript Files
├── routes/
│   └── web.php             # Web Routes
└── public/                 # Public Assets
```

## 🔐 Sistem Role & Permission

### Roles Available:
- **Admin**: Full access ke semua fitur
- **HR**: Akses manajemen karyawan dan HR
- **Manager**: Akses approval dan laporan
- **Employee**: Akses terbatas untuk data pribadi

### Middleware:
- `CheckRole`: Validasi role user untuk akses controller

## 📊 Database Schema

### Core Tables:
- `users` - Data pengguna sistem
- `roles` - Master role/peran
- `companies` - Data perusahaan
- `branch_offices` - Kantor cabang
- `work_units` - Unit kerja
- `positions` - Jabatan
- `employees` - Data karyawan

### HR Tables:
- `employee_attendances` - Absensi karyawan
- `employee_shifts` - Jadwal shift
- `employee_salaries` - Data gaji
- `employee_leaves` - Cuti karyawan
- `employee_documents` - Dokumen karyawan
- `employee_allowances` - Tunjangan karyawan

## 🌟 Fitur Unggulan

### 1. GPS Tracking Absensi
- Otomatis mendapatkan koordinat lokasi saat absen
- Validasi lokasi kerja
- Tracking IP address untuk keamanan

### 2. Auto-Calculate Features
- Perhitungan jam kerja otomatis
- Deteksi keterlambatan dan pulang cepat
- Kalkulasi gaji dengan komponen lengkap

### 3. Document Management
- Upload dokumen dengan validasi format
- Kategorisasi dokumen per jenis
- Sistem akses level (public/private/confidential)

### 4. Responsive Design
- Interface yang mobile-friendly
- Tailwind CSS untuk styling modern
- User experience yang optimal

## 🔄 Development Workflow

### Git Workflow:
```bash
# Create feature branch
git checkout -b feature/nama-fitur

# Commit changes
git add .
git commit -m "feat: deskripsi fitur"

# Push to repository
git push origin feature/nama-fitur
```

### Database Changes:
```bash
# Create migration
php artisan make:migration create_table_name

# Run migration
php artisan migrate

# Create seeder
php artisan make:seeder TableSeeder
```

## 📝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Developer

Developed by [Your Name] - [Your Email]

## 📞 Support

Untuk pertanyaan atau dukungan, silakan hubungi:
- Email: support@syncoreapp.com
- GitHub Issues: [Create Issue](https://github.com/username/syncoreapp/issues)

---

**SyncoreApp** - Solusi Manajemen Karyawan Modern 🚀
