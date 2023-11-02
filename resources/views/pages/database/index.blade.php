@push('styles')
    <link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <div class="flex items-center gap-10">
                <h2 class="font-bold text-xl text-gray-800 leading-tight">
                    {{ __('Database') }}
                </h2>
                {{-- Loading animation --}}
                <div role="status" class="hidden" id="data-loading">
                    <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                <div class="hidden">
                    <form action="{{ route('applicant.importupdate') }}" method="post" enctype="multipart/form-data"
                        class="flex items-center gap-2">
                        @csrf
                        @if (Auth::user()->role == 'P')
                            <input type="hidden" name="identity_user" value="{{ Auth::user()->identity }}"
                                placeholder="Nomor presenter">
                        @else
                            <div>
                                <x-select name="identity_user"
                                    class="w-52 {{ $errors->first('identity_user') ? 'border border-red-500' : '' }} text-xs mt-[0]"
                                    required>
                                    <option value="0">Pilih presenter</option>
                                    @foreach ($users as $presenter)
                                        <option value="{{ $presenter->identity }}">{{ $presenter->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        @endif
                        <input type="file" name="berkas" id="berkas"
                            class="text-xs border border-gray-200 bg-white px-2 py-1.5 rounded-md" required>
                        <button type="submit"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                            <i class="fa-solid fa-file-import"></i>
                        </button>
                    </form>
                </div>
                <button onclick="broadcastSchoolarship()"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-brands fa-whatsapp"></i>
                    <i class="fa-solid fa-bullhorn"></i>
                    <i class="fa-solid fa-graduation-cap"></i>
                </button>
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-lg items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">{{ $total }}</h2>
                </div>
                <button onclick="exportExcel()"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-file-excel"></i>
                </button>
                <a id="downloadBlast" onclick="downloadBlast()"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-download"></i>
                </a>
                <a id="downloadDP" onclick="downloadDP()"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-bullhorn"></i>
                </a>
                <a id="downloadCSV" onclick="downloadCSV()"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-file-csv"></i>
                </a>
                <a id="downloadVCF" onclick="downloadVCF()"
                    class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                    <i class="fa-solid fa-address-book"></i>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">
            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 mb-4 flex items-center p-4 mb-4 bg-red-400 text-white rounded-lg"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
            <div class="flex justify-between items-center gap-3 mx-2">
                <a href="{{ route('database.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-3 py-2 text-sm rounded-lg text-white"><i
                        class="fa-solid fa-circle-plus"></i> Tambah Data</a>
                <div class="flex gap-2">
                    @if ($nopresenter > 0)
                        <div class="relative">
                            @if (Auth::user()->role == 'A')
                                <span
                                    class="flex items-center justify-center right-[25px] top-[-10px] absolute bg-red-500 text-white w-4 h-4 rounded-xl text-[9px]">{{ $nopresenter }}</span>
                                <i class="fa-solid text-[25px] fa-person-circle-plus text-gray-500"></i>
                            @endif
                        </div>
                    @else
                        <input type="hidden" id="database_online" value="all">
                    @endif
                    <a href="{{ route('applicant.import') }}"
                        class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-lg text-sm space-x-1">
                        <i class="fa-solid fa-rotate"></i>
                    </a>
                    <button type="button" onclick="changeFilter()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-xs rounded-lg text-white">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <button type="button" onclick="resetFilter()"
                        class="bg-red-500 hover:bg-red-600 px-4 py-2 text-xs rounded-lg text-white">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </button>
                </div>
            </div>
            <section class="flex flex-col justify-center gap-3">
                @include('pages.database.database.filter')
            </section>
            <div class="bg-white overflow-hidden border md:rounded-xl">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto md:rounded-xl">
                        <table id="myTable" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-tl-lg">
                                        <i class="fa-solid fa-user"></i>
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Sumber Database
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Nama lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        No. Telpon (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Presenter
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Asal sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Jurusan
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-tr-lg">
                                        Tahun lulus
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center py-5 px-6">Belum ada data yang sesuai dengan
                                        filter yang diterapkan. <span onclick="changeFilter()"
                                            class="underline cursor-pointer">Lihat semua.</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{-- Script --}}
<script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
@include('pages.database.database.filterjs')
<script>
    const handleWhatsapp = async (target, message) => {
        await axios
            .post(
                `https://api.politekniklp3i-tasikmalaya.ac.id/whatsappbot/send`, {
                    target: target,
                    message: message,
                }
            )
            .then((res) => {
                console.log(res);
            })
            .catch((err) => {
                console.log(err);
            });
    }

    const broadcastSchoolarship = async () => {
        let status = document.getElementById('change_applicant').value;
        await axios.get(`/get/databasesbeasiswa`, {
                params: {
                    status: status,
                }
            })
            .then((res) => {
                let students = res.data.applicants;
                let index = 0;
                const sendWhatsappMessage = () => {
                    if (index < students.length) {
                        let student = students[index];
                        let message =
                            `Halo *${student.name}*,\nMohon untuk segera mengisi dan melengkapi persyaratan beasiswa di SBPMB Politeknik LP3I Kampus Tasikmalaya. Terima kasih.\n\nSalam, Politeknik LP3I Kampus Tasikmalaya.`;
                        let target = `${student.phone}@c.us`;
                        handleWhatsapp(target, message);
                        index++;
                        setTimeout(sendWhatsappMessage, 2000);
                    }
                };
                // sendWhatsappMessage();
                alert('Fungsi ini belum dijalankan');
            })
            .catch((err) => {
                console.log(err.message);
            });
    }
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    const getDataTable = async () => {
        const dataTableConfig = {
            ajax: {
                url: urlData,
                dataSrc: 'applicants'
            },
            order: [
                [2, 'desc']
            ],
            rowCallback: function(row, data, index) {
                if (data.presenter.phone == '6281313608558') {
                    $(row).css('background-color', '#dc2626');
                    $(row).css('color', 'white');
                }
            },
            columnDefs: [{
                    width: 10,
                    target: 0
                },
                {
                    width: 150,
                    target: 1
                },
                {
                    width: 200,
                    target: 2
                },
                {
                    width: 100,
                    target: 3
                },
                {
                    width: 150,
                    target: 4
                },
                {
                    width: 150,
                    target: 5
                },
                {
                    width: 100,
                    target: 6
                },
                {
                    width: 50,
                    target: 7
                },
            ],
            columns: [{
                    data: {
                        id: 'id',
                        identity: 'identity',
                        name: 'name',
                        phone: 'phone',
                        school: 'school',
                        year: 'year',
                        program: 'program',
                        source_id: 'source_id',
                        programtype_id: 'programtype_id',
                        status_id: 'status_id'
                    },
                    render: (data, type, row) => {
                        return `
                        <div class="flex items-center gap-1">
                            <button class="bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white" onclick="event.preventDefault(); copyRecord('${data.name}','${data.phone}','${data.school_applicant ? data.school_applicant.name : 'Tidak diketahui'}','${typeof(data.year) === 'number' ? data.year : 'Tidak diketahui'}','${data.program ? data.program : 'Tidak diketahui'}','${data.source_setting.name}','${data.programtype_id ? data.program_type.name : ''}','${data.status_id ? data.applicant_status.name : ''}')">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>`
                    }
                },
                {
                    data: {
                        status: 'applicant_status',
                        is_applicant: 'is_applicant',
                        is_register: 'is_register',
                        is_daftar: 'is_daftar',
                        schoolarship: 'schoolarship',
                    },
                    render: (data, type, row) => {
                        return `
                        <div class="flex gap-2">
                            <span class="text-[17px] ${data.is_applicant == 1 ? 'text-yellow-500' : 'text-gray-300'}"><i class="fa-solid fa-file-lines"></i></span>
                            <span class="text-[18px] ${data.is_daftar == 1 ? 'text-sky-500' : 'text-gray-300'}"><i class="fa-solid fa-id-badge"></i></span>
                            <span class="text-[15px] ${data.is_register == 1 ? 'text-emerald-500' : 'text-gray-300'}"><i class="fa-solid fa-user-check"></i></span>
                            <span class="text-[15px] ${data.schoolarship == 1 ? 'text-cyan-500' : 'text-gray-300'}"><i class="fa-solid fa-graduation-cap"></i></span>
                        </div>
                        `;
                    }
                },
                {
                    data: 'created_at',
                    render: (data) => {
                        return moment(data).tz('Asia/Jakarta').locale('id').format('L');
                    }
                },
                {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                },
                {
                    data: {
                        identity: 'identity',
                        name: 'name',
                        phone: 'phone'
                    },
                    render: (data, type, row) => {
                        let editUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`;
                    }
                },
                {
                    data: 'phone',
                    render: (data) => {
                        return typeof(data) == 'object' ? 'Tidak diketahui' : data;
                    }
                },
                {
                    data: 'presenter',
                    render: (data) => {
                        return typeof(data) == 'object' ? data.name : 'Tidak diketahui';
                    }
                },
                {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
                    }
                },
                {
                    data: 'major',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                },
                {
                    data: 'year',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                },
            ],
        }
        try {
            const response = await fetch(urlData);
            const data = await response.json();
            dataApplicants = data.applicants;
            dataTableInstance = $('#myTable').DataTable(dataTableConfig);
            dataTableInitialized = true;
            setTimeout(() => {
                changeFilter();
            }, 2000);
        } catch (error) {
            console.error("Error fetching data:", error);
            if (response) {
                const text = await response.text();
                console.error("Response text:", text);
            }
        }
    }

    const deleteRecord = (id) => {
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/database/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Error deleting record');
                    console.log(error);
                }
            })
        }
    }


    const copyRecord = (name, phone, school, year, program, source, programtype, status) => {
        const textarea = document.createElement("textarea");
        textarea.value =
            `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school} (${year})\nMinat Prodi: ${program}\nProgram Kuliah: ${programtype}\nSumber: ${source}`;
        textarea.style.position = "fixed";
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
        document.body.removeChild(textarea);
        alert('Link sudah disalin!');
    }

    const downloadBlast = () => {
        let content = '';
        let schoolSelect = document.getElementById('school');
        let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
        let schoolVal = selectedSchoolOption.innerText || 'all';
        let majorVal = document.getElementById('change_major').value || 'all';
        console.log(schoolVal);
        dataApplicants.forEach(applicant => {
            content += `${applicant.name},${applicant.phone == null ? '0000000000' : applicant.phone}\n`
        });
        var downloadBlast = document.getElementById('downloadBlast');
        var blob = new Blob([content], {
            type: "text/plain"
        });
        downloadBlast.href = URL.createObjectURL(blob);
        downloadBlast.download = `${schoolVal}-${majorVal}-FILEBLAST.txt`;
    }

    const downloadDP = () => {
        let content =
            'email,email,email,phone,phone,phone,madid,fn,ln,zip,ct,st,country,dob,doby,gen,age,uid\n';
        dataApplicants.forEach(applicant => {
            let fullName = applicant.name;
            let nameParts = fullName.split(' ');
            let fn = nameParts[0];
            let kotaKab = applicant.address ? (applicant.address.split("KOTA/KAB.")[1] ? applicant.address.split("KOTA/KAB.")[1].trim() : "") : '';
            let dateOfBirth = applicant.date_of_birth !== null ? applicant.date_of_birth : '';
            let tahun = dateOfBirth ? new Date(dateOfBirth).getFullYear() : '';
            let genderCode = applicant.gender;
            let gender = genderCode === 1 ? 'M' : 'F';
            let tahunSekarang = new Date().getFullYear();

            let ln = nameParts.slice(1).join(' ');

            let phoneNumber = applicant.phone;
            let formattedPhoneNumber = phoneNumber !== null ?
                `+${phoneNumber.slice(0, 2)} ${phoneNumber.slice(2, 5)} ${phoneNumber.slice(5, 7)} ${phoneNumber.slice(7, 9)} ${phoneNumber.slice(9, 11)}` :
                "";
            content +=
                `${applicant.email},${applicant.email},${applicant.email},${formattedPhoneNumber},${formattedPhoneNumber},${formattedPhoneNumber},,${fn},${ln},,${kotaKab},Jawa Barat,ID,${dateOfBirth},${tahun},${gender},${tahunSekarang - tahun},,\n`

        });
        var downloadDP = document.getElementById('downloadDP');
        var blob = new Blob([content], {
            type: "text/plain"
        });
        downloadDP.href = URL.createObjectURL(blob);
        downloadDP.download = `IKLAN.txt`;
        content = '';
    }

    const downloadCSV = () => {
        let content = 'Name,Group Membership,Phone 1 - Type,Phone 1 - Value\n';
        let schoolSelect = document.getElementById('school');
        let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
        let schoolVal = selectedSchoolOption.innerText || 'all';
        let majorVal = document.getElementById('change_major').value || 'all';
        dataApplicants.forEach(applicant => {
            let schoolNameWithoutSpace = applicant.school_applicant ? applicant.school_applicant.name
                .replace(/[\s-]/g, '') : null;
            let majorWithoutSpace = applicant.major == null ? '' : applicant.major.replace(/[\s-]/g, '');
            content +=
                `${applicant.name} ${schoolNameWithoutSpace} ${majorWithoutSpace} ${applicant.year == null ? '' : applicant.year},* myContacts,Mobile,+${applicant.phone}\n`
        });
        var downloadCSV = document.getElementById('downloadCSV');
        var blob = new Blob([content], {
            type: "text/plain"
        });
        downloadCSV.href = URL.createObjectURL(blob);
        downloadCSV.download = `${schoolVal}-${majorVal}-FILECONTACT.csv`;
    }

    const downloadVCF = () => {
        let content = '';
        let schoolSelect = document.getElementById('school');
        let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
        let schoolVal = selectedSchoolOption.innerText || 'all';
        let majorVal = document.getElementById('change_major').value || 'all';
        dataApplicants.forEach(applicant => {
            let schoolNameWithoutSpace = applicant.school_applicant ? applicant.school_applicant.name
                .replace(/[\s-]/g, '') : null;
            let majorWithoutSpace = applicant.major == null ? '' : applicant.major.replace(/[\s-]/g, '');
            content +=
                `BEGIN:VCARD\nVERSION:3.0\nFN:${applicant.name} ${schoolNameWithoutSpace} ${majorWithoutSpace} ${applicant.year == null ? '' : applicant.year}\nN:;D;;;\nTEL;TYPE=CELL:+${applicant.phone}\nCATEGORIES:myContacts\nEND:VCARD\n`
        });
        var downloadVCF = document.getElementById('downloadVCF');
        var blob = new Blob([content], {
            type: "text/vcard"
        });
        downloadVCF.href = URL.createObjectURL(blob);
        downloadVCF.download = `${schoolVal}-${majorVal}-FILECONTACT.vcf`;
    }

    const exportExcel = () => {
        $.ajax({
            url: urlExcel,
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            success: (response, status, xhr) => {
                console.log('Berhasil!');
                const filename = xhr.getResponseHeader('Content-Disposition')
                    .split(';')[1]
                    .trim()
                    .split('=')[1];
                const blob = new Blob([response], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error: () => {
                console.log('Terjadi kesalahan saat melakukan eksport');
            }
        });
    }
</script>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-input-single').select2();
        });
    </script>
@endpush
