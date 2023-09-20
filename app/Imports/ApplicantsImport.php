<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\ApplicantStatus;
use App\Models\FollowUp;
use App\Models\School;
use Maatwebsite\Excel\Concerns\ToModel;

class ApplicantsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        if (!empty($row[0])) {
            $schoolName = $row[6];
            $school = School::where('name', $schoolName)->first();
            return new Applicant([
                'pmb' => '2024',
                'name' => $row[2],
                'phone' => $row[3] ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null,
                'education' => $row[5] ? $row[5] : null,
                'school' => $school ? $school->id : null,
                'major' => $row[7] ? $row[7] : null,
                'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                'year' => $row[9] ? $row[9] : null,
                'place_of_birth' => $row[10] ? $row[10] : null,
                'date_of_birth' => $row[11] ? date('Y-m-d', strtotime($row[11])) : null,
                'gender' => ($row[12] === 'WANITA' || $row[12] === 'PEREMPUAN') ? 0 : 1,
                'religion' => $row[13],
                'identity_user' => '6282127356645',
                'source_id' => 7,
                'status_id' => !empty($row[16]) ? 
                (ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1) :
                1,
                'followup_id' => $row[17] ? 
                (FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1) :
                1,
                'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : 0,
                'achievement' => $row[19] ? $row[19] : null,
                'kip' => !empty($row[20]) ? (strcasecmp($row[20], 'YA') === 0 ? 1 : 0) : null,
                'relasi' => $row[21] ? $row[21] : null,
            ]);
        }
        return null;
    }
}
