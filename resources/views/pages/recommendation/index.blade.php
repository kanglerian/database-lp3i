@push('styles')
    <style>
        .js-example-input-single {
            display: flex;
            width: 100% !important;
        }

        .select2-selection {
            font-size: 12px !important;
            border-radius: 0.75rem !important;
            padding-top: 18px !important;
            padding-bottom: 18px !important;
            background: #ffffff !important;
            border: 1px solid #d1d5db !important;
        }

        .select2-results__option {
            font-size: 12px !important;
        }

        .select2-selection__rendered {
            position: absolute;
            top: 5px !important;
            font-size: 12px !important;
            left: 5px !important;
        }

        .select2-selection__arrow {
            position: absolute;
            top: 6px !important;
            right: 5px !important;
        }
    </style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <ul class="flex items-center gap-6">
                <li>
                    <a href="{{ route('database.index') }}"
                        class="{{ request()->routeIs(['database.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-loose' : '' }} font-bold text-md text-gray-800">Database</a>
                </li>
                <li>
                    <a href="{{ route('recommendation.index') }}"
                        class="{{ request()->routeIs(['recommendation.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-loose' : '' }} font-bold text-md text-gray-800">Rekomendasi</a>
                </li>
            </ul>
            {{-- <div>
                <div class="flex bg-gray-200 text-gray-700 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count">0</h2>
                </div>
            </div> --}}
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            @if (session('message'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-3 lg:px-8 space-y-4">
            <form method="GET" action="{{ route('recommendation.index') }}"
                class="w-full grid grid-cols-1 md:grid-cols-6 bg-gray-50 rounded-2xl border overflow-x-auto border-gray-200 text-gray-500 p-5 gap-3">
                @if (Auth::user()->role == 'A')
                    <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="identity" class="text-xs">Presenter:</label>
                        <select id="identity" name="identity"
                            class="js-example-basic-single bg-white border border-gray-200 w-full px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->identity }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                    <label for="school" class="text-xs">Asal sekolah:</label>
                    <select id="school" name="school"
                        class="js-example-basic-single w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                        <option value="all">Pilih</option>
                        <option value="0">Tidak diketahui</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                    <label for="source" class="text-xs">Sumber Data:</label>
                    <select id="source" name="source"
                        class="js-example-basic-single w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                        <option value="all">Pilih</option>
                        <option value="0">Tidak diketahui</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                    <label for="year" class="text-xs">Tahun lulus:</label>
                    <input type="number" id="year" name="year"
                        class="w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                        placeholder="Tahun lulus">
                </div>
                <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                    <label for="reference" class="text-xs">Referensi:</label>
                    <input type="text" id="reference" name="reference"
                        class="w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                        placeholder="Referensi">
                </div>
                <div class="flex items-end gap-2 mb-1 p-1 md:p-0">
                    <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <a href="{{ route('recommendation.index') }}"
                        class="bg-red-500 hover:bg-red-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </a>
                    {{-- <button type="button" onclick="exportExcel()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-file-excel"></i>
                    </button> --}}
                </div>
            </form>

            <div class="bg-gray-50 overflow-hidden border rounded-3xl">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto sm:rounded-xl">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        No.
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        No. HP (Whatsapp)
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Asal Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tahun Lulus
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Nama MGM
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Presenter
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Referensi
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Sumber
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3text-center">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recommendations as $key => $recommendation)
                                    <tr class="border-b border-gray-200">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                            {{ $recommendations->perPage() * ($recommendations->currentPage() - 1) + $key + 1 }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $recommendation->name }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                            {{ $recommendation->phone }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $recommendation->schoolapplicant->name ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                            {{ $recommendation->class }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $recommendation->year }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                            {{ $recommendation->applicant->name ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $recommendation->applicant->presenter->name }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                            {{ $recommendation->reference ?? 'Tidak diketahui' }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-700">
                                            {{ $recommendation->sourcesetting->name }}
                                        </td>
                                        <td class="px-6 py-4 bg-gray-50">
                                            <form action="{{ route('recommendation.change', $recommendation->id) }}"
                                                method="post" class="w-full">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" value="{{ $recommendation->status }}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block pe-8 px-3 p-2.5"
                                                    onchange="this.form.submit()">
                                                    <option disabled>Pilih</option>
                                                    <option value="0"
                                                        {{ $recommendation->status == 0 ? 'selected' : '' }}>Tidak
                                                        diketahui</option>
                                                    <option value="1"
                                                        {{ $recommendation->status == 1 ? 'selected' : '' }}>Batal
                                                    </option>
                                                    <option value="2"
                                                        {{ $recommendation->status == 2 ? 'selected' : '' }}>
                                                        Pertimbangkan</option>
                                                    <option value="3"
                                                        {{ $recommendation->status == 3 ? 'selected' : '' }}>Prospek
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('recommendation.edit', $recommendation->id) }}"
                                                class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('recommendation.destroy', $recommendation->id) }}"
                                                method="post" class="inline-block"
                                                onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="p-1">
                                {{ $recommendations->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function getUrlParams() {
                const urlParams = new URLSearchParams(window.location.search);
                const identity = urlParams.get('identity') || 'all';
                const school = urlParams.get('school') || 'all';
                const source = urlParams.get('source') || 'all';
                const year = urlParams.get('year');
                const reference = urlParams.get('reference');
                document.getElementById('identity').value = identity;
                document.getElementById('school').value = school;
                document.getElementById('source').value = source;
                document.getElementById('year').value = year;
                document.getElementById('reference').value = reference;
            }
            getUrlParams();

            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            }
        </script>

        {{-- @push('scripts')
        <script src="{{ asset('js/exceljs.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-input-single').select2({
                    tags: true,
                });
            });
            let dataTableDataRecommendationInstance;
            let dataTableDataRecommendationInitialized = false;
            let identityVal = document.getElementById('identity_user').value;
            let roleVal = document.getElementById('role').value;
            let urlRecommendation =
                `/api/recommendation?identityVal=${identityVal}&roleVal=${roleVal}`;
            let dataRecommendation;
        </script>

        <script>
            const changeFilter = () => {
                let queryParams = [];

                let identityVal = document.getElementById('identity_user').value;
                let roleVal = document.getElementById('role').value;

                let schoolVal = document.getElementById('school').value || 'all';
                let sourceVal = document.getElementById('source_id').value || 'all';
                let yearVal = document.getElementById('year').value || 'all';
                let referenceVal = document.getElementById('reference').value || 'all';

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                if (sourceVal !== 'all') {
                    queryParams.push(`sourceVal=${sourceVal}`);
                }

                if (referenceVal !== 'all') {
                    queryParams.push(`referenceVal=${referenceVal}`);
                }

                queryParams.push(`schoolVal=${schoolVal}`);
                queryParams.push(`sourceVal=${sourceVal}`);
                queryParams.push(`yearVal=${yearVal}`);
                queryParams.push(`referenceVal=${referenceVal}`);

                let queryString = queryParams.join('&');

                urlRecommendation = `/api/recommendation?${queryString}`;

                if (dataTableDataRecommendationInstance) {
                    showLoadingAnimation();
                    dataTableDataRecommendationInstance.clear();
                    dataTableDataRecommendationInstance.destroy();
                    getDataTableRecommendation()
                        .then((response) => {
                            dataTableDataRecommendationInstance = $('#table-recommendation').DataTable(
                                response
                                .config);
                            dataTableDataRecommendationInitialized = response.initialized;
                            hideLoadingAnimation();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

            const getDataTableRecommendation = async () => {
                return new Promise(async (resolve, reject) => {
                    try {
                        const response = await axios.get(urlRecommendation);
                        const recommendations = response.data.recommendations;
                        dataRecommendation = recommendations;

                        document.getElementById('count').innerText = recommendations.length;

                        let columnConfigs = [{
                                data: 'id',
                                render: (data, type, row, meta) => {
                                    return meta.row + 1;
                                },
                            },
                            {
                                data: 'name',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'phone',
                                render: (data, type, row, meta) => {
                                    return `<a href="https://wa.me/${data}" class="underline">${data}</a>`;
                                }
                            },
                            {
                                data: 'schoolapplicant',
                                render: (data, type, row, meta) => {
                                    return data ? data.name : 'Tidak diketahui';
                                }
                            },
                            {
                                data: 'class',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'year',
                                render: (data, type, row, meta) => {
                                    return data;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data, type, row, meta) => {
                                    return data ? data.name : 'Tidak diketahui';
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data, type, row, meta) => {
                                    return data ? data.presenter.name : 'Tidak diketahui';
                                }
                            },
                            {
                                data: 'reference',
                                render: (data, type, row, meta) => {
                                    return data ?? 'Tidak diketahui';
                                }
                            },
                            {
                                data: 'sourcesetting',
                                render: (data, type, row, meta) => {
                                    return data.name;
                                }
                            },
                            {
                                data: {
                                    id: 'id',
                                    status: 'status',
                                },
                                render: (data, type, row, meta) => {
                                    let statusLabel = "";
                                    switch (parseInt(data.status)) {
                                        case 0:
                                            statusLabel = "Pilih";
                                            break;
                                        case 1:
                                            statusLabel = "Batal";
                                            break;
                                        case 2:
                                            statusLabel = "Pertimbangkan";
                                            break;
                                        case 3:
                                            statusLabel = "Prospek";
                                            break;
                                        default:
                                            statusLabel = "Pilih";
                                            break;
                                    }
                                    let editUrl = "{{ route('recommendation.change', ':id') }}"
                                        .replace(
                                            ':id',
                                            data.id);
                                    return `
                                    <form id="statusForm_${data.id}" method="POST" action="${editUrl}" class="w-[130px]">
                                        @csrf
                                        @method('PATCH')
                                        <select onchange="document.getElementById('statusForm_${data.id}').submit()" name="status" class="w-full px-3 text-xs text-gray-900 border border-gray-300 rounded-xl bg-gray-50">
                                            <option value="${data.status}" selected>
                                                ${statusLabel}
                                            </option>
                                            <option value="3">Prospek</option>
                                            <option value="2">Pertimbangkan</option>
                                            <option value="1">Batal</option>
                                            <option value="0">Tidak diketahui</option>
                                        </select>
                                    </form>
                                    `;
                                }
                            },
                            {
                                data: 'id',
                                render: (data, type, row, meta) => {
                                    let editUrl = "{{ route('recommendation.edit', ':id') }}".replace(':id',data);
                                    return `
                                    <a href="${editUrl}" class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-lg text-xs text-white">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button type="button" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    `;
                                }
                            }
                        ];

                        const dataTableConfig = {
                            data: recommendations,
                            columnDefs: [{
                                width: 50,
                                target: 0
                            }],
                            createdRow: (row, data, index) => {
                                if (index % 2 === 0) {
                                    $(row).css('background-color', '#f9fafb');
                                }
                            },
                            columns: columnConfigs,
                        }

                        let results = {
                            config: dataTableConfig,
                            initialized: true
                        }

                        resolve(results);
                    } catch (error) {
                        reject(error)
                    }
                });
            }


        </script>
        <script>
            const promiseDataRecommendation = () => {
                showLoadingAnimation();
                Promise.all([
                        getDataTableRecommendation(),
                    ])
                    .then((response) => {
                        let responseDTR = response[0];
                        dataTableDataRecommendationInstance = $('#table-recommendation').DataTable(
                            responseDTR
                            .config);
                        dataTableDataRecommendationInitialized = responseDTR.initialized;
                        hideLoadingAnimation();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
            promiseDataRecommendation();
        </script>

        <script>
            const exportExcel = async () => {
                try {
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Data');
                    let header = ['No', 'Nama Lengkap', 'No. HP', 'Asal Sekolah', 'Kelas', 'Tahun Lulus', 'Nama MGM', 'Presenter', 'WA BLAST'];
                    let dataExcel = [
                        header,
                    ];
                    dataRecommendation.forEach((student, index) => {
                        let studentBucket = [];
                        studentBucket.push(
                            `${index + 1}`,
                            `${student.name ? student.name : 'Tidak diketahui'}`,
                            `${student.phone ? student.phone : 'Tidak diketahui'}`,
                            `${student.schoolapplicant ? student.schoolapplicant.name : 'Tidak diketahui'}`,
                            `${student.class ? student.class : 'Tidak diketahui'}`,
                            `${student.year ? student.year : 'Tidak diketahui'}`,
                            `${student.applicant ? student.applicant.name : 'Tidak diketahui'}`,
                            `${student.applicant ? student.applicant.presenter.name : 'Tidak diketahui'}`,
                            `${student.name ? student.name : 'Tidak diketahui'},${student.phone ? student.phone : '00000000'}`,
                        );
                        dataExcel.push(studentBucket);
                    });

                    let dateTime = new Date();
                    const day = dateTime.getDate();
                    const month = dateTime.getMonth();
                    const year = dateTime.getFullYear();
                    const hours = dateTime.getHours();
                    const minutes = dateTime.getMinutes();
                    const seconds = dateTime.getSeconds();
                    const formattedDate = `export_data-recommendation_${hours}${minutes}${seconds}${day}${month}${year}`;

                    worksheet.addRows(dataExcel);

                    const blob = await workbook.xlsx.writeBuffer();
                    const blobData = new Blob([blob], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });

                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blobData);
                    link.download = `${formattedDate}.xlsx`;

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                } catch (error) {
                    console.error('Error:', error);
                }
            };
        </script>
    @endpush --}}

    </x-app-layout>
