<?php

namespace App\Imports;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\ApplicantStatus;
use App\Models\FollowUp;
use App\Models\School;
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
        $numbers_unique = mt_rand(1, 1000000000);
        $phone = !empty($row[3]) ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null;
        $applicant = Applicant::where('phone', $phone)->first();
        $schoolName = $row[6];
        $school = School::where('name', $schoolName)->first();

        $create_father = [
            'identity_user' => $numbers_unique,
            'gender' => 1,
            'job' => !empty($row[20]) ? $row[20] : null,
        ];
        $create_mother = [
            'identity_user' => $numbers_unique,
            'gender' => 0,
            'job' => !empty($row[21]) ? $row[21] : null,
        ];

        if (!empty($row[0])) {
            if ($applicant) {
                $data_applicant = [
                    'pmb' => $row[1],
                    'name' => !empty($row[2]) ? $row[2] : null,
                    'education' => !empty($row[5]) ? $row[5] : null,
                    'school' => $school ? $school->id : null,
                    'major' => !empty($row[7]) ? $row[7] : null,
                    'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                    'year' => !empty($row[9]) ? $row[9] : null,
                    'place_of_birth' => !empty($row[10]) ? $row[10] : null,
                    'date_of_birth' => !empty($row[11]) ? Date::excelToDateTimeObject($row[11])->format('Y-m-d') : null,
                    'gender' => ($row[12] === 'WANITA' || $row[12] === 'PEREMPUAN') ? 0 : ($row[12] === null ? null : 1),
                    'religion' => !empty($row[13]) ? $row[13] : null,
                    'identity_user' => $this->identityUser,
                    'source_id' => 7,
                    'status_id' => !empty($row[16]) ?
                        (ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1) :
                        1,
                    'followup_id' => $row[17] ?
                        (FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1) :
                        1,
                    'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : 0,
                    'achievement' => !empty($row[19]) ? $row[19] : null,
                    'kip' => !empty($row[22]) ? (strcasecmp($row[22], 'YA') === 0 ? 1 : 0) : null,
                    'relation' => !empty($row[23]) ? $row[23] : null,
                ];

                $data_father = [
                    'job' => !empty($row[20]) ? $row[20] : null,
                ];

                $data_mother = [
                    'job' => !empty($row[21]) ? $row[21] : null,
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
                    'identity' => $numbers_unique,
                    'pmb' => $row[1],
                    'name' => !empty($row[2]) ? $row[2] : null,
                    'phone' => !empty($row[3]) ? (substr($row[3], 0, 1) === '0' ? '62' . substr($row[3], 1) : '62' . $row[3]) : null,
                    'education' => !empty($row[5]) ? $row[5] : null,
                    'school' => $school ? $school->id : null,
                    'major' => !empty($row[7]) ? $row[7] : null,
                    'email' => !empty($row[8]) && !Applicant::where('email', $row[8])->exists() ? $row[8] : null,
                    'year' => !empty($row[9]) ? $row[9] : null,
                    'place_of_birth' => !empty($row[10]) ? $row[10] : null,
                    'date_of_birth' => !empty($row[11]) ? Date::excelToDateTimeObject($row[11])->format('Y-m-d') : null,
                    'gender' => ($row[12] === 'WANITA' || $row[12] === 'PEREMPUAN') ? 0 : ($row[12] === null ? null : 1)
                    ,
                    'religion' => !empty($row[13]) ? $row[13] : null,
                    'identity_user' => $this->identityUser,
                    'source_id' => 7,
                    'status_id' => !empty($row[16]) ?
                        (ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($row[16])])->value('id') ?? 1) :
                        1,
                    'followup_id' => $row[17] ?
                        (FollowUp::whereRaw('LOWER(name) = ?', [strtolower($row[17])])->value('id') ?? 1) :
                        1,
                    'come' => strcasecmp($row[18], 'SUDAH') === 0 ? 1 : 0,
                    'achievement' => !empty($row[19]) ? $row[19] : null,
                    'kip' => !empty($row[22]) ? (strcasecmp($row[22], 'YA') === 0 ? 1 : 0) : null,
                    'relation' => !empty($row[23]) ? $row[23] : null,
                ]);
            }
        }
        return null;
    }
}