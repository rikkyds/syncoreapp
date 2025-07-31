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
- **Quick Create Employee**: Form cepat untuk menambah karyawan dengan 3 field utama
- **Complete Employee Profile**: Form lengkap dengan semua detail karyawan
- **Auto-Generated Employee ID**: ID karyawan otomatis (EMP0001, EMP0002, dst)
- **Auto User Account Creation**: Otomatis membuat akun user dengan password default
- **Informasi Pribadi**: Data personal, kontak, dan keluarga
- **Informasi Kepegawaian**: Status, jabatan, unit kerja
- **Dokumen**: Upload dan manajemen dokumen karyawan

### Employee Profile Management
- **Modern Tab Interface**: Detail karyawan dengan 5 tab terorganisir
- **Pendidikan**: Riwayat pendidikan dengan sertifikat/ijazah
- **Keahlian**: Skills dengan tingkat proficiency dan sertifikat
- **Pengalaman Kerja**: Work experience dengan detail lengkap dan referensi
- **Data Keluarga**: Informasi keluarga dengan kontak darurat
- **Interactive Forms**: Form modern dengan conditional fields dan JavaScript

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

### Project Management
- **Project Tracking**: Manajemen proyek dengan timeline
- **SIKOJA Integration**: Sistem Kontrol Jasa dengan budget tracking
- **Support Request**: Sistem tiket dukungan dengan PDF export
- **PPT & PDK Details**: Detail Pengeluaran Proyek dan Dana Kontrak

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **File Upload**: Laravel Storage
- **JavaScript**: Vanilla JS untuk interaktivitas
- **UI Components**: Modern responsive design dengan dark mode support

## 📋 Persyaratan Sistem

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL >= 5.7
- Web Server (Apache/Nginx)

## 🔧 Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/rikkyds/SyncoreIndonesia.git
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

## 🎯 Quick Start Commands

### Create Test User
```bash
php artisan create:test-user
```

### Update User Role
```bash
php artisan update:user-role {user_id} {role_name}
```

### Test Quick Employee Creation
```bash
php artisan test:quick-employee
```

## 📁 Struktur Project

```
syncoreapp/
├── app/
│   ├── Http/Controllers/     # Controllers
│   │   ├── EmployeeController.php
│   │   ├── SkillController.php
│   │   ├── ProjectController.php
│   │   └── SupportRequestController.php
│   ├── Models/              # Eloquent Models
│   │   ├── Employee.php
│   │   ├── Education.php
│   │   ├── Skill.php
│   │   ├── WorkExperience.php
│   │   └── FamilyMember.php
│   ├── Console/Commands/    # Artisan Commands
│   │   ├── CreateTestUser.php
│   │   ├── UpdateUserRole.php
│   │   └── TestQuickEmployee.php
│   └── Http/Middleware/     # Custom Middleware
│       └── CheckRole.php
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Database Seeders
├── resources/
│   ├── views/              # Blade Templates
│   │   ├── employees/      # Employee Management Views
│   │   ├── projects/       # Project Management Views
│   │   ├── support-requests/ # Support System Views
│   │   └── layouts/        # Layout Templates
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
- **Karyawan**: Akses terbatas untuk data pribadi

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

### Employee Related Tables:
- `educations` - Riwayat pendidikan karyawan
- `skills` & `skill_categories` - Master keahlian
- `employee_skills` - Pivot table keahlian karyawan
- `work_experiences` - Pengalaman kerja
- `family_members` - Data keluarga karyawan

### HR Tables:
- `employee_attendances` - Absensi karyawan
- `employee_shifts` - Jadwal shift
- `employee_salaries` - Data gaji
- `employee_leaves` - Cuti karyawan
- `employee_documents` - Dokumen karyawan
- `employee_allowances` - Tunjangan karyawan

### Project Management Tables:
- `projects` - Data proyek
- `sikojas` - Sistem Kontrol Jasa
- `support_requests` - Tiket dukungan
- `ppt_details` - Detail Pengeluaran Proyek
- `pdk_details` - Detail Dana Kontrak

## 🌟 Fitur Unggulan

### 1. Quick Create Employee
- Form cepat dengan 3 field utama (Nama, Email, Telepon)
- Auto-generate Employee ID (EMP0001, EMP0002, dst)
- Auto-create user account dengan password default 'syncore123'
- Auto-assign role 'karyawan'
- Menggunakan default values untuk foreign keys

### 2. Modern Employee Profile
- Tab interface dengan 5 section: Personal, Education, Skills, Experience, Family
- Gradient header cards dengan employee photo
- Interactive forms dengan conditional fields
- File upload dengan drag & drop interface
- Real-time form validation

### 3. Indonesian Localization
- Semua interface menggunakan Bahasa Indonesia
- Form labels, buttons, dan messages dalam Bahasa Indonesia
- Status translations (Tetap, Kontrak, Masa Percobaan, Magang)
- Relationship translations (Ayah, Ibu, Suami/Istri, Anak, dll)

### 4. GPS Tracking Absensi
- Otomatis mendapatkan koordinat lokasi saat absen
- Validasi lokasi kerja
- Tracking IP address untuk keamanan

### 5. Auto-Calculate Features
- Perhitungan jam kerja otomatis
- Deteksi keterlambatan dan pulang cepat
- Kalkulasi gaji dengan komponen lengkap

### 6. Document Management
- Upload dokumen dengan validasi format
- Kategorisasi dokumen per jenis
- Sistem akses level (public/private/confidential)

### 7. Responsive Design
- Interface yang mobile-friendly
- Tailwind CSS untuk styling modern
- Dark mode support
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

## 🆕 Recent Updates

### v2.1.0 - UI/UX Improvements & Bug Fixes (July 2025)
- ✅ Perbaikan halaman shift: Mengubah opsi shift menjadi PAGI, SIANG, MALAM, dan NON SHIFT
- ✅ Penambahan tab Shift Kerja pada halaman detail karyawan
- ✅ Perbaikan halaman absensi: Metode absensi aktif secara default
- ✅ Verifikasi supervisor pada absensi hanya muncul jika karyawan terlibat dalam project
- ✅ Penambahan fitur foto profil karyawan dengan preview
- ✅ Perbaikan halaman tambah gaji karyawan dengan perhitungan otomatis
- ✅ Perbaikan halaman dokumen karyawan dengan validasi file
- ✅ Penambahan halaman detail dan edit dokumen karyawan
- ✅ Perbaikan teks bahasa Inggris menjadi bahasa Indonesia pada semua halaman

### v2.0.0 - Employee Management Enhancement
- ✅ Quick Create Employee feature
- ✅ Modern employee detail page dengan tab system
- ✅ Complete Indonesian localization
- ✅ Enhanced form validation dan error handling
- ✅ Auto-generated employee IDs
- ✅ Improved user experience dengan modern UI

### v1.5.0 - Project Management
- ✅ Project tracking system
- ✅ SIKOJA integration
- ✅ Support request system dengan PDF export
- ✅ Budget tracking dan financial management

### v1.0.0 - Core HR System
- ✅ Employee management
- ✅ Attendance system
- ✅ Payroll management
- ✅ Leave management
- ✅ Document management

## 📝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Developer

Developed by Syncore Indonesia Team - RDS (syncore.rikky@gmail.com)

## 📞 Support

Untuk pertanyaan atau dukungan, silakan hubungi:
- Email: syncore.rikky@gmail.com
- GitHub Issues: [Create Issue](https://github.com/rikkyds/SyncoreIndonesia/issues)

---

**SyncoreApp** - Solusi Manajemen Karyawan Modern 🚀
