{{-- Modal school --}}
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="schoolModal">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="title_school">
                    Tambah Sekolah
                </h3>
                <button type="button" onclick="changeSchoolModal(this)" data-modal-target="schoolModal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="defaultModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('schools.store') }}" id="formSchoolModal">
                @csrf
                <div class="p-4 space-y-6">
                    <div>
                        <label for="name_school" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            Sekolah</label>
                        <input type="text" id="name_school" name="name" maxlength="100" placeholder="Isi nama sekolah disini.."class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="region_school" class="block mb-2 text-sm font-medium text-gray-900">Wilayah</label>
                        <select name="region" id="region_school"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option selected>Pilih Wilayah</option>
                            <option value="KAB. TASIKMALAYA">KAB. TASIKMALAYA</option>
                            <option value="TASIKMALAYA">TASIKMALAYA</option>
                            <option value="GARUT">GARUT</option>
                            <option value="BANJAR">BANJAR</option>
                            <option value="CIAMIS">CIAMIS</option>
                            <option value="PANGANDARAN">PANGANDARAN</option>
                            <option value="PANGANDARAN">PANGANDARAN</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="submit" id="formSchoolButton"
                        class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button type="button" data-modal-target="schoolModal" onclick="changeSchoolModal(this)"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Script school --}}
<script>
    const changeSchoolModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        let status = document.getElementById(modalTarget);
        let url = "{{ route('schools.store') }}";
        document.getElementById('title_school').innerText = `Tambah Sekolah`;
        document.getElementById('name_school').value = '';
        document.getElementById('region_school').value = '';
        document.getElementById('formSchoolButton').innerText = 'Simpan';
        document.getElementById('formSchoolModal').setAttribute('action', url);

        const elementsToRemove = document.querySelectorAll('[name="_method"]');
        if (elementsToRemove.length > 0) {
            elementsToRemove.forEach((element) => {
                element.remove();
            });
        } else {
            console.log("No elements found with the specified name.");
        }
        status.classList.toggle('hidden');
    }

    const editSchoolModal = (button) => {
        const formModal = document.getElementById('formSchoolModal');
        const modalTarget = button.dataset.modalTarget;
        const id = button.dataset.id;
        const name = button.dataset.name;
        const region = button.dataset.region;
        let url = "{{ route('schools.update', ':id') }}".replace(':id', id);
        let status = document.getElementById(modalTarget);
        document.getElementById('title_school').innerText = `Edit Sekolah ${name}`;
        document.getElementById('name_school').value = name;
        document.getElementById('region_school').value = name;
        document.getElementById('formSchoolButton').innerText = 'Simpan perubahan';
        document.getElementById('formSchoolModal').setAttribute('action', url);
        let csrfToken = document.createElement('input');
        csrfToken.setAttribute('type', 'hidden');
        csrfToken.setAttribute('name', '_token');
        csrfToken.setAttribute('value', '{{ csrf_token() }}');
        formModal.appendChild(csrfToken);

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'PATCH');
        formModal.appendChild(methodInput);

        status.classList.toggle('hidden');
    }

    const deleteSchool = (item) => {
        let id = item.dataset.id;
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/school/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Kategori dipakai, tidak bisa dihapus.');
                }
            })
        }
    }
</script>
