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
        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0 h-10">
            <ul class="flex items-center gap-6">
                <li>
                    <a href="{{ route('database.index') }}"
                        class="{{ request()->routeIs(['database.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-10' : '' }} font-bold text-md text-gray-800 leading-tight">{{ __('Database') }}</a>
                </li>
                <li>
                    <a href="{{ route('recommendation.index') }}"
                        class="{{ request()->routeIs(['recommendation.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-10' : '' }} font-bold text-md text-gray-800 leading-tight">{{ __('Data Rekomendasi ✨') }}</a>
                </li>
            </ul>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('message'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-check"></i>
                    <div class="ml-3 text-sm font-reguler">
                        {{ session('message') }}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="alert" class="mx-2 flex items-center p-4 mb-4 bg-red-500 text-white rounded-xl"
                    role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div
                class="w-full grid grid-cols-1 md:grid-cols-4 bg-gray-50 rounded-2xl border overflow-x-auto border-gray-200 text-gray-500 p-5 md:gap-3">
                <input type="hidden" id="role" value="{{ Auth::user()->role }}">
                @if (Auth::user()->role == 'A')
                    <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                        <label for="identity_user" class="text-xs">Presenter:</label>
                        <select id="identity_user"
                            class="js-example-basic-single bg-white border border-gray-200 w-full px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih presenter</option>
                            <option value="6281313608558">Administrator</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->identity }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" id="identity_user" value="{{ Auth::user()->identity }}">
                @endif
                <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="school" class="text-xs">Asal sekolah:</label>
                    <select id="school"
                        class="js-example-basic-single w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                        <option value="all">Pilih sekolah</option>
                        <option value="0">Tidak diketahui</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="year" class="text-xs">Tahun lulus:</label>
                    <input type="number" id="year"
                        class="w-full bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                        placeholder="Tahun lulus">
                </div>
                <div class="flex items-end gap-2 mb-1">
                    <button type="button" onclick="changeFilter()"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <button type="button" onclick="resetFilter()"
                        class="bg-red-500 hover:bg-red-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden border rounded-3xl">
                <div class="p-6 bg-white">
                    <div class="relative overflow-x-auto rounded-3xl">
                        <table id="table-recommendation" class="w-full text-sm text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 rounded-l-xl">
                                        <i class="fa-solid fa-user"></i>
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Nama Lengkap
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        No. HP
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Asal Sekolah
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Kelas
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Tahun Lulus
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Nama MGM
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Presenter
                                    </th>
                                    <th scope="col" class="px-6 py-3 whitespace-nowrap">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 rounded-r-xl">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center py-5 px-6">Belum ada data yang sesuai dengan
                                        filter yang diterapkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            let dataTableDataRecommendationInstance;
            let dataTableDataRecommendationInitialized = false;
            let identityVal = document.getElementById('identity_user').value;
            let roleVal = document.getElementById('role').value;
            let urlRecommendation =
                `/api/recommendation?identityVal=${identityVal}&roleVal=${roleVal}`;
        </script>

        <script>
            const changeFilter = () => {
                let queryParams = [];

                let identityVal = document.getElementById('identity_user').value;
                let roleVal = document.getElementById('role').value;

                let schoolVal = document.getElementById('school').value || 'all';
                let yearVal = document.getElementById('year').value || 'all';

                if (identityVal !== 'all') {
                    queryParams.push(`identityVal=${identityVal}`);
                }

                if (roleVal !== 'all') {
                    queryParams.push(`roleVal=${roleVal}`);
                }

                queryParams.push(`schoolVal=${schoolVal}`);
                queryParams.push(`yearVal=${yearVal}`);

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
                                    return data.name;
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
                                    return data.name;
                                }
                            },
                            {
                                data: 'applicant',
                                render: (data, type, row, meta) => {
                                    return data.presenter.name;
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
                                    return `
                                    <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg text-xs text-white" onclick="event.preventDefault(); deleteRecord(${data})">
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

            const deleteRecord = (id) => {
                if (confirm('Apakah kamu yakin akan menghapus data?')) {
                    $.ajax({
                        url: `/recommendation/${id}`,
                        type: 'POST',
                        data: {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response[0]);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert('Error deleting record');
                        }
                    })
                }
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
    @endpush

</x-app-layout>