<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Registrasi Kuliah</title>
    <style>
        ul {
            line-height: 28px;
        }
    </style>
</head>

<body>
    <main>
        <header>
            <p>Halo {{ $data['name'] ?? 'Calon Mahasiswa' }},</p>
            <p>Selamat! Kami dengan senang hati menginformasikan bahwa proses registrasi kuliah Anda telah berhasil. Berikut adalah rincian pendaftaran Anda:</p>
        </header>
        <ul>
            <li>
                <strong>Nama lengkap:</strong>
                <span>{{ $data['name'] ?? 'Calon Mahasiswa' }}</span>
            </li>
            <li>
                <strong>Program studi:</strong>
                <span>{{ $data['program'] ?? 'D3 Manajemen Informatika' }}</span>
            </li>
            <li>
                <strong>Asal sekolah:</strong>
                <span>{{ $data['school'] ?? 'SMK Negeri 1 Konoha' }}</span>
            </li>
            <li>
                <strong>Jurusan/Tahun lulus:</strong>
                <span>{{ $data['major'] ?? 'Teknik Ninja' }}</span>
                <span>({{ $data['year'] ?? '2016' }})</span>
            </li>
            <li>
                <strong>Nomor telepon:</strong>
                <span>{{ $data['phone'] ?? '6281000000000' }}</span>
            </li>
        </ul>
        <ul style="margin-top: 30px">
            <li>
                <strong>Email:</strong>
                <span>{{ $data['email'] ?? 'ninja@konoha.com' }}</span>
            </li>
            <li>
                <strong>Password:</strong>
                <span>{{ $data['phone'] ?? '6281000000000' }}</span>
            </li>
        </ul>
        <p>Apabila Anda memerlukan bantuan atau memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami melalui Whatsapp {{ $data['presenter'] ?? 'Administrator' }} yang tertera pada portal E-PMB.</p>
        <p>Terima kasih atas perhatian Anda. Kami berharap Anda sukses dalam perjalanan akademik Anda di Politeknik LP3I Kampus Tasikmalaya.</p>
        <div>
            Salam hormat,<br/>
            Tim Administrasi PMB<br/>
            Politeknik LP3I Kampus Tasikmalaya
        </div>
    </main>
</body>

</html>
