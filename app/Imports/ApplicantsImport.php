<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\ApplicantStatus;
use App\Models\FollowUp;
use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ApplicantsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $numbers_unique = mt_rand(1, 1000000000);
        $schoolName = $row[6];
        $school = School::where('name', $schoolName)->first();

        $data_father = [
            'identity_user' => $numbers_unique,
            'gender' => 1,
        ];
        $data_mother = [
            'identity_user' => $numbers_unique,
            'gender' => 0,
        ];

        if (!empty($row[0])) {

            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            return new Applicant([
                'identity' => $numbers_unique,
                'pmb' => $row[1],
                'name' => !empty($row[2]) ? $row[2] : null,
                'phone' => $row[3] ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null,
                'education' => !empty($row[5]) ? $row[5] : null,
                'school' => $school ? $school->id : null,
                'major' => !empty($row[7]) ? $row[7] : null,
                'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                'year' => !empty($row[9]) ? $row[9] : null,
                'place_of_birth' => !empty($row[10]) ? $row[10] : null,
                'date_of_birth' => !empty($row[11]) ? Date::excelToDateTimeObject($row[11])->format('Y-m-d') : null,
                'gender' => ($row[12] === 'WANITA' || $row[12] === 'PEREMPUAN') ? 0 : 1,
                'religion' => $row[13],
                'identity_user' => '6282127951392',
                'source_id' => 7,
                'status_id' => !empty($row[16]) ?
                    (ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1) :
                    1,
                'followup_id' => $row[17] ?
                    (FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1) :
                    1,
                'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : 0,
                'achievement' => !empty($row[19]) ? $row[19] : null,
                'kip' => !empty($row[20]) ? (strcasecmp($row[20], 'YA') === 0 ? 1 : 0) : null,
                'relasi' => !empty($row[21]) ? $row[21] : null,
            ]);
        }
        return null;
    }
}