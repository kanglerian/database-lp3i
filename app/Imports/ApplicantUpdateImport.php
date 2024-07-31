<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\ApplicantStatus;
use App\Models\FollowUp;
use App\Models\School;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApplicantUpdateImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private $identityUser;

    public function __construct($identityUser)
    {
        $this->identityUser = $identityUser;
    }

    public function model(array $row)
    {
        $identity_val = Str::uuid();
        $phone = !empty($row[3]) ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null;
        $applicant = Applicant::where('phone', $phone)->first();
        $schoolName = $row[6];
        $school = School::where('name', $schoolName)->first();

        $program = null;

        if (!empty($row[26])) {
            switch ($row[26]) {
                case 'AB':
                    $program = 'D3 Administrasi Bisnis';
                    break;
                case 'MI':
                    $program = 'D3 Manajemen Informatika';
                    break;
                case 'MKP':
                    $program = 'D3 Manajemen Keuangan Perbankan';
                    break;
                case 'MP':
                    $program = 'D3 Manajemen Pemasaran';
                    break;
                case 'TO':
                    $program = 'Teknik Otomotif Vokasi 2 Tahun';
                    break;
                default:
                    $program = null;
            }
        }

        $dusun = !empty($row[30]) ? ucwords($row[30]) : null;
        $rtrw = !empty($row[31]) ? ucwords($row[31]) : null;
        $kelurahan = !empty($row[32]) ? ucwords($row[32]) : null;
        $kecamatan = !empty($row[33]) ? ucwords($row[33]) : null;
        $kotakab = !empty($row[34]) ? ucwords($row[34]) : null;

        $create_father = [
            'identity_user' => $identity_val,
            'gender' => 1,
            'job' => null,
        ];
        $create_mother = [
            'identity_user' => $identity_val,
            'gender' => 0,
            'job' => null,
        ];

        if (!empty($row[0])) {
            if ($applicant) {
                $data_applicant = [
                    'pmb' => $row[1],
                    'name' => !empty($row[2]) ? ucwords(strtolower($row[2])) : null,
                    'education' => !empty($row[5]) ? $row[5] : null,
                    'school' => $school ? $school->id : null,
                    'major' => !empty($row[7]) ? $row[7] : null,
                    // 'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                    'year' => !empty($row[9]) ? $row[9] : null,
                    'place_of_birth' => !empty($row[10]) ? $row[10] : null,
                    'date_of_birth' => !empty($row[11]) ? Date::excelToDateTimeObject($row[11])->format('Y-m-d') : null,
                    'gender' => $row[12] === 'WANITA' || $row[12] === 'PEREMPUAN' ? 0 : ($row[12] === null ? null : 1),
                    'religion' => !empty($row[13]) ? $row[13] : null,
                    'identity_user' => $this->identityUser,
                    'source_id' => 7,
                    'status_id' => !empty($row[16]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1 : 1,
                    'followup_id' => $row[17] ? FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1 : 1,
                    'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : (strcasecmp($row[18], 'BELUM') === 0 ? 0 : null),
                    'achievement' => !empty($row[19]) ? $row[19] : null,
                    'kip' => !empty($row[22]) ? (strcasecmp($row[22], 'YA') === 0 ? 1 : 0) : null,
                    'relation' => !empty($row[23]) ? $row[23] : null,
                    'known' => strcasecmp($row[24], 'YA') === 0 ? 1 : (strcasecmp($row[24], 'TIDAK') === 0 ? 0 : null),
                    'planning' => !empty($row[25]) ? $row[25] : null,
                    'program' => $program,
                    'other_campus' => !empty($row[27]) ? $row[27] : null,
                    'income_parent' => !empty($row[28]) ? $row[28] : null,
                    'social_media' => !empty($row[29]) ? $row[29] : null,
                    'address' => $dusun . ' ' . 'RT/RW. ' . $rtrw . ' ' . 'DESA/KEL. ' . $kelurahan . ' ' . 'KEC. ' . $kecamatan . ' ' . 'KOTA/KAB. ' . $kotakab,
                ];

                $data_father = [
                    'job' => null,
                ];

                $data_mother = [
                    'job' => null,
                ];

                $applicantFather = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
                $applicantMother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

                $applicantFather->update($data_father);
                $applicantMother->update($data_mother);
                $applicant->update($data_applicant);
            } else {
                ApplicantFamily::create($create_father);
                ApplicantFamily::create($create_mother);
                return new Applicant([
                    'identity' => $identity_val,
                    'pmb' => $row[1],
                    'name' => !empty($row[2]) ? ucwords(strtolower($row[2])) : null,
                    'phone' => !empty($row[3]) ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null,
                    'education' => !empty($row[5]) ? $row[5] : null,
                    'school' => $school ? $school->id : null,
                    'major' => !empty($row[7]) ? $row[7] : null,
                    // 'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                    'year' => !empty($row[9]) ? $row[9] : null,
                    'place_of_birth' => !empty($row[10]) ? $row[10] : null,
                    'date_of_birth' => !empty($row[11]) ? Date::excelToDateTimeObject($row[11])->format('Y-m-d') : null,
                    'gender' => $row[12] === 'WANITA' || $row[12] === 'PEREMPUAN' ? 0 : ($row[12] === null ? null : 1),
                    'religion' => !empty($row[13]) ? $row[13] : null,
                    'identity_user' => $this->identityUser,
                    'source_id' => 7,
                    'status_id' => !empty($row[16]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1 : 1,
                    'followup_id' => $row[17] ? FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1 : 1,
                    'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : (strcasecmp($row[18], 'BELUM') === 0 ? 0 : null),
                    'achievement' => !empty($row[19]) ? $row[19] : null,
                    'kip' => !empty($row[22]) ? (strcasecmp($row[22], 'YA') === 0 ? 1 : 0) : null,
                    'relation' => !empty($row[23]) ? $row[23] : null,
                    'known' => strcasecmp($row[24], 'YA') === 0 ? 1 : (strcasecmp($row[24], 'TIDAK') === 0 ? 0 : null),
                    'planning' => !empty($row[25]) ? $row[25] : null,
                    'program' => $program,
                    'other_campus' => !empty($row[27]) ? $row[27] : null,
                    'income_parent' => !empty($row[28]) ? $row[28] : null,
                    'social_media' => !empty($row[29]) ? $row[29] : null,
                    'address' => $dusun . ' ' . 'RT/RW. ' . $rtrw . ' ' . 'DESA/KEL. ' . $kelurahan . ' ' . 'KEC. ' . $kecamatan . ' ' . 'KOTA/KAB. ' . $kotakab,
                ]);
            }
        }
        return null;
    }
}
