<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FileUploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_upload')->insert([
            [
                'name' => 'Foto',
                'namefile' => 'foto',
                'accept' => 'image/*',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'KTP',
                'namefile' => 'ktp',
                'accept' => 'image/*',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Ijazah',
                'namefile' => 'ijazah',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Transkip Nilai',
                'namefile' => 'transkip-nilai',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Raport Semester 5 dan 6',
                'namefile' => 'raport-semester-5-dan-6',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Akta Kelahiran',
                'namefile' => 'akta-kelahiran',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Kartu Keluarga',
                'namefile' => 'kartu-keluarga',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Sertifikat Pendukung (Prestasi)',
                'namefile' => 'sertifikat-pendukung',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Surat Keterangan Bekerja',
                'namefile' => 'surat-keterangan-bekerja',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Surat Keterangan Berwirausaha',
                'namefile' => 'surat-keterangan-berwirausaha',
                'accept' => '.pdf',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Bukti Pembayaran',
                'namefile' => 'bukti-pembayaran',
                'accept' => 'image/*',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Foto Rumah (Luar & Dalam)',
                'namefile' => 'foto-rumah-luar-dan-dalam',
                'accept' => 'image/*',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],[
                'name' => 'Bukti Tarif Daya Listrik Rumah',
                'namefile' => 'bukti-tarif-daya-listrik',
                'accept' => 'image/*',
                'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ],
        ]);
    }
}
