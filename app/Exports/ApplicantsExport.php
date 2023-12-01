<?php

namespace App\Exports;

use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicantsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    protected $dateStart;
    protected $dateEnd;
    protected $yearGrad;
    protected $schoolVal;
    protected $birthdayVal;
    protected $pmbVal;
    protected $sourceVal;
    protected $statusVal;

    public function __construct($dateStart, $dateEnd, $yearGrad, $schoolVal, $birthdayVal, $pmbVal, $sourceVal, $statusVal)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->yearGrad = $yearGrad;
        $this->schoolVal = $schoolVal;
        $this->birthdayVal = $birthdayVal;
        $this->pmbVal = $pmbVal;
        $this->sourceVal = $sourceVal;
        $this->statusVal = $statusVal;
    }

    public function headings(): array
    {
        return [
            '#',
            'PMB',
            'Presenter',
            'No. Identity',
            'Nama lengkap',
            'Jenis kelamin',
            'Tingkat',
            'Nama sekolah',
            'Jurusan',
            'Kelas',
            'Tahun lulus',
            'Tempat lahir',
            'Tanggal lahir',
            'Agama',
            'Email',
            'No. Whatsapp',
            'Tipe program',
            'Program',
            'Sumber',
            'Status',
        ];
    }

    public function map($applicant): array
    {
        // Kolom-kolom dari relasi SourceSetting, ApplicantStatus, ProgramType
        $sourceName = $applicant->SourceSetting->name;
        $statusName = $applicant->ApplicantStatus->name;
        // $programType = $applicant->ProgramType->name;

        // Kolom-kolom yang sudah Anda atur sebelumnya
        $gender = ($applicant->gender == 1) ? 'Laki-laki' : 'Perempuan';

        return [
            'created_at' => $applicant->created_at,
            'pmb' => $applicant->pmb,
            'identity_user' => $applicant->identity_user,
            'identity' => $applicant->identity,
            'name' => $applicant->name,
            'gender' => $gender,
            'education' => $applicant->education,
            'school' => $applicant->school,
            'major' => $applicant->major,
            'class' => $applicant->class,
            'year' => $applicant->year,
            'place_of_birth' => $applicant->place_of_birth,
            'date_of_birth' => $applicant->date_of_birth,
            'religion' => $applicant->religion,
            'email' => $applicant->email,
            'phone' => $applicant->phone,
            // 'program_type' => $programType,
            'program' => $applicant->program,
            'source_name' => $sourceName,
            'status_name' => $statusName,
            //Tambahkan kolom-kolom lain yang Anda butuhkan
        ];
    }

    public function query()
    {
        $applicantsQuery = Applicant::query();

        if (Auth::user()->role === 'P') {
            $applicantsQuery->where('identity_user', Auth::user()->identity);
        }

        if ($this->dateStart !== null && $this->dateStart !== 'all' && $this->dateEnd !== null && $this->dateEnd !== 'all') {
            $applicantsQuery->whereBetween('created_at', [$this->dateStart, $this->dateEnd]);
        }

        if ($this->yearGrad !== 'all' && $this->yearGrad !== null) {
            $applicantsQuery->where('year', $this->yearGrad);
        }

        if ($this->schoolVal !== 'all' && $this->schoolVal !== null) {
            $applicantsQuery->where('school', $this->schoolVal);
        }

        if ($this->birthdayVal !== 'all' && $this->birthdayVal !== null) {
            $applicantsQuery->where('date_of_birth', $this->birthdayVal);
        }

        if ($this->pmbVal !== 'all' && $this->pmbVal !== null) {
            $applicantsQuery->where('pmb', $this->pmbVal);
        }

        if ($this->sourceVal !== 'all' && $this->sourceVal !== null) {
            $applicantsQuery->where('source_id', $this->sourceVal);
        }

        if ($this->statusVal !== 'all' && $this->statusVal !== null) {
            $applicantsQuery->where('status_id', $this->statusVal);
        }

        $applicantsQuery->with(['SourceSetting', 'ApplicantStatus', 'ProgramType']);

        return $applicantsQuery;
    }
}
