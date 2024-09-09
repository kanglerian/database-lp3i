# PMB Online System

> Sebuah aplikasi web untuk memfasilitasi pendaftaran mahasiswa baru secara online. Aplikasi ini menyediakan fitur untuk mengunggah berkas, mengelola data pendaftaran, mengelola data sekolah, target capaian dan memonitor status registrasi oleh admin.

## Teknologi yang Digunakan

- **FullStack:** Laravel Breeze (TailwindCSS, Alpine JS)  v8.75
- **Database:** MySQL
- **Deployment:** cPanel

---

## Arsitektur Aplikasi

Aplikasi ini dibangun dengan pendekatan arsitektur Monolitich.

---

### Diagram Arsitektur

> null

---

## Modul-Modul Utama dan Fungsi

### Modul Utama

> null

---

#### Setting

> Mengelola data awal atau data pengaturan dari aplikasi.

##### - Program Type

- File: ```routes/web.php```
- Endpoint: ```/programtype```
- Controller: ```ProgramTypeController```
- Deskripsi: Mengelola operasi CRUD untuk tipe program studi. Seperti kelas karyawan dan kelas reguler.

##### - Source

- File: ```routes/web.php```
- Endpoint: ```/source```
- Controller: ```SourceController```
- Deskripsi: Mengelola operasi CRUD untuk sumber database.

##### - File Upload

- File: ```routes/web.php```
- Endpoint: ```/fileupload```
- Controller: ```FileUploadController```
- Deskripsi: Mengelola operasi CRUD untuk file upload.

##### - Status Aplikan

- File: ```routes/web.php```
- Endpoint: ```/applicantstatus```
- Controller: ```ApplicantStatusController```
- Deskripsi: Mengelola operasi CRUD untuk status aplikan.

##### - Follow Up

- File: ```routes/web.php```
- Endpoint: ```/followup```
- Controller: ```FollowUpController```
- Deskripsi: Mengelola operasi CRUD untuk follow up.

#### Sekolah

> Mengelola data sekolah.

##### - Schools

- File: ```routes/web.php```
- Endpoint: ```/schools```
- Controller: ```SchoolController```
- Deskripsi: Mengelola operasi CRUD untuk data sekolah.

##### - Import Schools

- File: ```routes/web.php```
- Method: ```POST```
- Endpoint: ```/import/schools```
- Controller: ```SchoolController@import```
- Deskripsi: Operasi mengimport data sekolah secara massal.

##### - Data Sekolah Berdasarkan Source

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/get/schools/setting```
- Controller: ```SchoolController@setting```
- Deskripsi: Operasi mengambil data sekolah berdasarkan sumber database.

##### - Migrasi Data Sekolah

- File: ```routes/web.php```
- Method: ```POST```
- Endpoint: ```/migration/schools```
- Controller: ```SchoolController@migration```
- Deskripsi: Operasi transfer data dari satu sekolah ke sekolah lain.

##### - Hapus Data Sekolah

- File: ```routes/web.php```
- Method: ```POST```
- Endpoint: ```/clear/schools```
- Controller: ```SchoolController@clear```
- Deskripsi: Operasi hapus data sekolah yang data mahasiswanya kosong.

#### Aplikan

> Mengelola database.

##### - CRUD Resource Aplikan

- File: ```routes/web.php```
- Endpoint: ```/database```
- Controller: ```ApplicantController```
- Deskripsi: Mengelola operasi CRUD untuk data sekolah.

##### - Update Status Aplikan

- File: ```routes/web.php```
- Method: ```PATCH```
- Endpoint: ```/status/database/aplikan/{id}```
- Controller: ```StatusApplicantController@update```
- Deskripsi: Mengubah status aplikan.

##### - Delete Status Aplikan

- File: ```routes/web.php```
- Method: ```DELETE```
- Endpoint: ```/status/database/aplikan/{id}```
- Controller: ```StatusApplicantController@destroy```
- Deskripsi: Menghapus status aplikan.

##### - Delete Status Daftar

- File: ```routes/web.php```
- Method: ```DELETE```
- Endpoint: ```/status/database/daftar/{id}```
- Controller: ```StatusDaftarController@destroy```
- Deskripsi: Menghapus status daftar.

##### - Delete Status Registrasi

- File: ```routes/web.php```
- Method: ```DELETE```
- Endpoint: ```/status/database/registrasi/{id}```
- Controller: ```StatusRegistrasiController@destroy```
- Deskripsi: Menghapus status register.

##### - Import Data Aplikan

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/import/applicants```
- Controller: ```ApplicantController@import```
- Deskripsi: Mengimport data aplikan dari Spreadsheet.

##### - Check Data Spreadsheet

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/import/check-spreadsheet/{sheet}```
- Controller: ```ApplicantController@check_spreadsheet```
- Deskripsi: Memeriksa jumlah data dari Spreadsheet.

##### - Export Data Spreadsheet

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/applicants/export/{dateStart?}/{dateEnd?}/{yearGrad?}/{schoolVal?}/{birthdayVal?}/{pmbVal?}/{sourceVal?}/{statusVal?}```
- Controller: ```ApplicantController@export```
- Deskripsi: Export data ke format excel.

##### - GET Database Beasiswa

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/get/databasesbeasiswa```
- Controller: ```ApplicantController@get_beasiswa```
- Deskripsi: GET database berdasarkan beasiswa to output JSON.

##### - Set Is Applicant

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/isapplicant/{identity?}```
- Controller: ```ApplicantController@is_applicant```
- Deskripsi: Update set status is applicant.

##### - Set Is Scholarship

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/isschoolarship/{identity?}```
- Controller: ```ApplicantController@is_schoolarship```
- Deskripsi: Update set status is scholarship.

##### - Chat

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/chat/{identity?}```
- Controller: ```ApplicantController@chats```
- Deskripsi: GET riwayat chats.

##### - File

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/file/{identity?}```
- Controller: ```ApplicantController@files```
- Deskripsi: GET riwayat berkas.

##### - Achievement

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/achievement/{identity?}```
- Controller: ```ApplicantController@achievements```
- Deskripsi: GET riwayat prestasi.

##### - Organization

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/organization/{identity?}```
- Controller: ```ApplicantController@organizations```
- Deskripsi: GET riwayat organisasi.

##### - Scholarship

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/scholarship/{identity?}```
- Controller: ```ApplicantController@scholarships```
- Deskripsi: GET riwayat hasil tes beasiswa.

##### - Print

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/print/database/{id}```
- Controller: ```ApplicantController@print```
- Deskripsi: GET print out.

#### Presenter

> Mengelola presenter.

##### - CRUD Resource Presenter

- File: ```routes/web.php```
- Endpoint: ```/presenters```
- Controller: ```PresenterController```
- Deskripsi: Mengelola operasi CRUD untuk presenters.

##### - GET Data JSON

- File: ```routes/web.php```
- Method: ```GET```
- Endpoint: ```/get/presenters```
- Controller: ```ApplicantController@get_all```
- Deskripsi: GET presenter to output JSON.