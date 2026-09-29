# 📚 Panduan Setup PostgreSQL & Import Database ke pgAdmin 4

## Daftar Isi
1. [Install PostgreSQL](#1-install-postgresql)
2. [Install pgAdmin 4](#2-install-pgadmin-4)
3. [Membuat Database](#3-membuat-database)
4. [Import SQL File ke PostgreSQL](#4-import-sql-file)
5. [Update Konfigurasi PHP Project](#5-update-konfigurasi-php-project)
6. [Test Koneksi Database](#6-test-koneksi-database)
7. [Troubleshooting](#7-troubleshooting)

---

## 1. Install PostgreSQL

### Windows
1. Download dari: https://www.postgresql.org/download/windows/
2. Jalankan installer
3. Catat password untuk user `postgres`
4. Port default: `5432`
5. Biarkan default options lainnya

### macOS (Homebrew)
```bash
brew install postgresql
brew services start postgresql
```

### Linux (Ubuntu/Debian)
```bash
sudo apt-get update
sudo apt-get install postgresql postgresql-contrib
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

### Verifikasi Instalasi
```bash
psql --version
psql -U postgres -c "SELECT version();"
```

---

## 2. Install pgAdmin 4

### Option A: Web Version (Recommended)
```bash
# Windows / macOS
1. Download dari: https://www.pgadmin.org/download/
2. Install sesuai sistem operasi Anda
3. Jalankan aplikasi
4. Akses: http://localhost:80 (default)

# Linux
sudo apt-get install pgadmin4
```

### Option B: Docker (Recommended for Development)
```bash
docker run -p 80:80 \
  -e PGADMIN_DEFAULT_EMAIL=admin@admin.com \
  -e PGADMIN_DEFAULT_PASSWORD=admin \
  -d dpage/pgadmin4
```

### Akses pgAdmin 4
- **URL**: http://localhost:80 atau http://localhost
- **Email**: admin@admin.com (atau email yang Anda set)
- **Password**: admin (atau password yang Anda set)

---

## 3. Membuat Database

### Method 1: Menggunakan pgAdmin 4 (GUI)

1. **Login ke pgAdmin 4**
   - Buka browser → http://localhost

2. **Koneksi ke Server PostgreSQL**
   - Left Menu → Servers
   - Klik kanan → Register → Server
   - **Name**: `localhost` (atau nama custom)
   - **Host**: `127.0.0.1` atau `localhost`
   - **Port**: `5432`
   - **Username**: `postgres`
   - **Password**: (password yang Anda set saat install)
   - Save

3. **Membuat Database Baru**
   - Klik expand server → Databases
   - Klik kanan Databases → Create → Database
   - **Database name**: `validas1_ehm_report`
   - **Encoding**: `UTF8`
   - **Owner**: `postgres`
   - Save

### Method 2: Menggunakan Command Line
```bash
psql -U postgres

# Di prompt psql:
CREATE DATABASE validas1_ehm_report 
ENCODING 'UTF8' 
OWNER postgres 
TEMPLATE template0;

# Verifikasi
\l
# Output akan menampilkan database yang baru dibuat

\q
# Exit
```

---

## 4. Import SQL File ke PostgreSQL

### Method 1: Menggunakan pgAdmin 4 Query Tool (Recommended)

1. **Buka pgAdmin 4**
   - Koneksi ke server PostgreSQL

2. **Select Database**
   - Left Menu → Servers → localhost → Databases
   - Klik kanan `validas1_ehm_report` → Query Tool

3. **Load SQL File**
   - Klik icon "Open File" (folder icon) di Query Tool
   - Pilih file: `validas1_ehm_report_postgresql.sql`

4. **Execute Query**
   - Klik tombol "Execute" (▶ icon)
   - Atau tekan: **F5** atau **Ctrl+Enter**

5. **Verifikasi**
   - Lihat output di tab "Data Output"
   - Tidak boleh ada error

### Method 2: Menggunakan Command Line (psql)

```bash
# Method 1: Direct import
psql -U postgres -d validas1_ehm_report -f validas1_ehm_report_postgresql.sql

# Method 2: Interactive
psql -U postgres -d validas1_ehm_report

# Di prompt psql, copy-paste isi file SQL atau:
\i /path/to/validas1_ehm_report_postgresql.sql

# Exit
\q
```

### Method 3: Menggunakan GUI File Manager (pgAdmin 4)

1. Di Query Tool pgAdmin 4
2. Menu → File → Open
3. Pilih file SQL
4. Otomatis ter-load di Query Editor
5. Execute

---

## 5. Update Konfigurasi PHP Project

### Langkah-langkah:

#### A. Copy Environment Template
```bash
# Di root project folder
cp .env.postgresql.example .env
```

#### B. Edit `.env` File
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=validas1_ehm_report
DB_USERNAME=postgres
DB_PASSWORD=your_postgres_password
DB_CHARSET=utf8
DB_SCHEMA=public
```

#### C. Jika Menggunakan CodeIgniter 3

Edit `application/config/database.php`:

```php
$db['default'] = array(
    'dsn'	=> '',
    'hostname' => '127.0.0.1',
    'username' => 'postgres',
    'password' => 'your_postgres_password',
    'database' => 'validas1_ehm_report',
    'dbdriver' => 'postgre',  // PENTING: ubah ke 'postgre'
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => '',
    'port' => 5432,
);
```

#### D. Jika Menggunakan Laravel

Edit `config/database.php`:

```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', 5432),
    'database' => env('DB_DATABASE', 'validas1_ehm_report'),
    'username' => env('DB_USERNAME', 'postgres'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'schema' => 'public',
    'sslmode' => 'prefer',
],
```

#### E. Install/Enable PHP PostgreSQL Extension

**Windows:**
- Buka `php.ini`
- Cari baris: `;extension=pgsql`
- Uncomment menjadi: `extension=pgsql`
- Restart Apache/PHP

**Linux:**
```bash
sudo apt-get install php-pgsql
sudo systemctl restart apache2
# atau
sudo systemctl restart nginx
```

**macOS:**
```bash
brew tap homebrew/php
brew install php@7.4-pgsql  # sesuaikan versi PHP
```

---

## 6. Test Koneksi Database

### Method 1: PHP Script
```php
<?php
$host = "127.0.0.1";
$port = 5432;
$database = "validas1_ehm_report";
$user = "postgres";
$password = "your_postgres_password";

try {
    $conn = new PDO(
        "pgsql:host=$host;port=$port;dbname=$database",
        $user,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Koneksi berhasil!";
    
    // Test query
    $result = $conn->query("SELECT COUNT(*) as count FROM site");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    echo "\n✅ Tabel 'site' ada, total record: " . $row['count'];
} catch (PDOException $e) {
    echo "❌ Koneksi gagal: " . $e->getMessage();
}
?>
```

### Method 2: Command Line
```bash
# Test dengan psql
psql -U postgres -d validas1_ehm_report -c "SELECT COUNT(*) as total_users FROM \"user\";"

# Output harusnya menampilkan jumlah user
```

### Method 3: pgAdmin 4 Query Tool
```sql
-- Buka Query Tool di pgAdmin dan jalankan:
SELECT 
    tablename 
FROM pg_tables 
WHERE schemaname = 'public'
ORDER BY tablename;

-- Harusnya menampilkan semua tabel yang di-import
```

---

## 7. Troubleshooting

### Error 1: "Connection refused"
```
SOLUSI:
- Pastikan PostgreSQL sudah running: sudo systemctl status postgresql
- Pastikan port 5432 tidak diblokir firewall
- Cek DB_HOST di .env (gunakan 127.0.0.1, bukan localhost untuk Windows)
```

### Error 2: "FATAL: Ident authentication failed"
```
SOLUSI:
- Edit file: /etc/postgresql/VERSION/main/pg_hba.conf
- Ubah 'ident' menjadi 'md5' atau 'password'
- Restart PostgreSQL: sudo systemctl restart postgresql
```

### Error 3: "ROLE postgres does not exist"
```
SOLUSI:
- Gunakan username yang benar saat install PostgreSQL
- Atau create user baru:
  createuser -U postgres -s newuser -P
```

### Error 4: "Database encoding mismatch"
```
SOLUSI:
- Delete database lama
- Buat database baru dengan:
  CREATE DATABASE validas1_ehm_report ENCODING 'UTF8' TEMPLATE template0;
```

### Error 5: "PHP extension pgsql not found"
```
SOLUSI:
- Windows: Uncomment extension=pgsql di php.ini
- Linux: sudo apt-get install php-pgsql && sudo systemctl restart apache2
- macOS: brew install php@VERSION-pgsql
- Verifikasi: php -m | grep pgsql
```

### Error 6: "Sequence does not exist"
```
SOLUSI:
- Jalankan ulang SQL file yang sudah disesuaikan dengan PostgreSQL
- Pastikan setval() statements di akhir file SQL ter-execute
- Atau manual set:
  SELECT setval('site_id_seq', (SELECT MAX(id) FROM site) + 1);
```

---

## 📋 Checklist Setup

- [ ] PostgreSQL terinstall dan berjalan
- [ ] pgAdmin 4 terinstall dan bisa diakses
- [ ] Database `validas1_ehm_report` sudah dibuat
- [ ] SQL file sudah di-import ke database
- [ ] PHP extension pgsql sudah diaktifkan
- [ ] File `.env` sudah dikonfigurasi dengan PostgreSQL
- [ ] Database connection test berhasil
- [ ] Aplikasi PHP bisa connect ke database

---

## 🎯 Quick Start (TL;DR)

```bash
# 1. Create database
psql -U postgres -c "CREATE DATABASE validas1_ehm_report ENCODING 'UTF8' TEMPLATE template0;"

# 2. Import SQL
psql -U postgres -d validas1_ehm_report -f validas1_ehm_report_postgresql.sql

# 3. Update .env
cp .env.postgresql.example .env
# Edit .env dengan credentials PostgreSQL Anda

# 4. Test connection
php -r "new PDO('pgsql:host=127.0.0.1;port=5432;dbname=validas1_ehm_report', 'postgres', 'password');" && echo "✅ Connected!"
```

---

## 📞 Referensi & Links

- PostgreSQL Documentation: https://www.postgresql.org/docs/
- pgAdmin 4 Documentation: https://www.pgadmin.org/docs/
- PHP PDO PostgreSQL: https://www.php.net/manual/en/ref.pdo-pgsql.php
- Migration Tips MySQL to PostgreSQL: https://wiki.postgresql.org/wiki/Converting_from_MySQL_to_PostgreSQL

---

**Dibuat untuk project:** validasiqab7pg-sys/ereport-ehm  
**Database:** validas1_ehm_report  
**Format:** PostgreSQL 12+
