# Deskripsi Umum

Aplikasi PMB Online adalah sebuah platform yang dirancang untuk memfasilitasi proses penerimaan mahasiswa baru. Aplikasi ini memiliki beberapa halaman utama yang ditujukan untuk siswa, presenter, dan admin dengan berbagai fitur yang lengkap. 

<hr>

## Fitur

**1. Manajemen Database**

Fitur ini digunakan untuk **mengelola database** mahasiswa **registrasi**, **daftar**, **aplikan**, **beasiswa** dan **calon mahasiswa** serta **data rekomendasi** dari mahasiswa registrasi. Dilengkapi dengan **data pendukung** dan **CV Generator**.

- Quick search
- Search data / Filter data
- Biodata pribadi
- Biodata orang tua
- Data Prestasi
- Data Pengalaman Organisasi
- Riwayat Chat WA Blast (WA Sender)
- CV Generator
- WA Blast Generator (.txt)
- Contact Saver Generator (.csv)
- Excel Generator (.xlsx)

**2. Manajemen Sekolah**

Fitur ini digunakan untuk **mengelola data sekolah**. Terdapat hal penting yang perlu diperhatikan seperti **jenis sekolah** (SMA, SMK, MA, Paket), **status sekolah** (Negeri, Swasta), **lokasi sekolah** (lang, latt, provinsi, kota/kabupaten).

- Terintegrasi dengan API Leaflet
- Informasi registrasi berdasarkan sekolah
- Informasi database berdasarkan sekolah
- Data sekolah berdasarkan wilayah sekolah
- Data sekolah berdasarkan jenis sumber database
- Database berdasarkan jenis sekolah / status sekolah

**3. Manajemen Presenter**

Fitur ini digunakan untuk **mengelola presenter**.

- Sales Revenue
- Sales Volume
- Target Database
- Data registrasi berdasarkan presenter
- Jumlah database berdasarkan presenter

**4. Manajemen Pembayaran**

Fitur ini digunakan untuk **mengelola pembayaran** berupa pendaftaran dan registrasi mahasiswa.

- Target
- Jumlah pendaftar
- Jumlah register
- Nominal kas
- Nominal potensi omzet

**5. Manajemen Akun**

Fitur ini digunakan untuk **mengelola akun** mahasiswa, calon mahasiswa, dan presenter.

- RESTful API
- JWT Authentication

<hr>

## API Integration

**1. SBPMB LP3I**

Integrasi ini digunakan untuk mendukung terpusatnya data dengan platform Tes Beasiswa (SBPMB). Begitu pula dengan hasil dari tes beasiswa ini akan muncul di halaman PMB Online di profil mahasiswa tab ``beasiswa`` yang bisa dibuka oleh Presenter dan Administrator atau di menu ``Assessment``.

- RESTful API Biodata Pribadi
- RESTful API Biodata Orangtua
- RESTful API Program Studi
- JWT Authentication

**2. Psikotest**

Integrasi ini digunakan untuk mendukung terpusatnya data dengan platform Tes Kecerdasan (Psikotest).

- RESTful API Akun
- JWT Authentication
  
**3. MISIL V4**

Integrasi ini digunakan untuk mendukung terpusatnya data register dengan platform MISIL V4.

- Data aplikan
- Data pendaftar
- Data register
  
**4. Upload Berkas**

Integrasi ini digunakan untuk mendukung terpusatnya data upload berkas. Hasil dari upload berkas ini akan muncul di halaman PMB Online di profil mahasiswa tab ``berkas`` yang bisa dibuka oleh Presenter dan Administrator beserta di aplikasi ``SBPMB``.

- RESTful API Upload Berkas

<hr>

## Database

Database sudah dibuatkan melalui ``migration laravel`` beserta ``seeder`` untuk data awal. Silahkan untuk melihat di folder ``database/migrations`` dan ``database/seeders``.

<hr>

# Instalasi

1. Clone aplikasi dari Github
  ```bash
  git clone https://github.com/kanglerian/database-lp3i
  ```
2. Lakukan ``composer install`` untuk mengunduh **vendor**.
  ```bash
  cd database-lp3i
  composer install
  ```
3. Lakukan ``npm install`` untuk mengunduh **node_modules**.
  ```bash
  npm install
  ```
4. Ubah file ``.env`` dan ubah database beserta username dan passwordnya.
5. Lakukan migration dan seeding untuk membuat table di database dan data dummy.
  ```bash
  php artisan migrate
  php artisan db:seed
  ```

<hr>

# License

Aplikasi ini adalah perangkat lunak berpemilik dan tidak bersifat open source. Semua hak dilindungi. [kanglerian@gmail.com](mailto:kanglerian@gmail.com).