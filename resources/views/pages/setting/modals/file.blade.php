{{-- Modal File --}}
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="fileModal">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full md:w-1/2 relative bg-white rounded-lg shadow mx-5">
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="title_file">
                    Tambah File Upload
                </h3>
                <button type="button" onclick="changeFileModal(this)" data-modal-target="fileModal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="defaultModal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('fileupload.store') }}" id="formFileModal">
                @csrf
                <div class="p-4 space-y-6">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            File</label>
                        <input type="text" id="name_file" name="name" placeholder="Isi nama berkas disini.."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Accept</label>
                        <input type="text" id="accept_file" name="accept" placeholder="Isi file accept disini.."
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            required>
                    </div>
                </div>
                <div class="flex items-center p-4 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="submit" id="formFileButton"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button type="button" data-modal-target="fileModal" onclick="changeFileModal(this)"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
  </div>
{{-- Script File --}}
<script>
  const changeFileModal = (button) => {
      const modalTarget = button.dataset.modalTarget;
      let status = document.getElementById(modalTarget);
      let url = "{{ route('fileupload.store') }}";
      document.getElementById('title_file').innerText = `Tambah File Upload`;
      document.getElementById('name_file').value = '';
      document.getElementById('accept_file').value = '';
      document.getElementById('formFileButton').innerText = 'Simpan';
      document.getElementById('formFileModal').setAttribute('action', url);

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

  const editFileModal = (button) => {
      const formModal = document.getElementById('formFileModal');
      const modalTarget = button.dataset.modalTarget;
      const id = button.dataset.id;
      const name = button.dataset.name;
      const accept = button.dataset.accept;
      let url = "{{ route('fileupload.update', ':id') }}".replace(':id', id);
      let status = document.getElementById(modalTarget);
      document.getElementById('title_file').innerText = `Edit File Upload ${name}`;
      document.getElementById('name_file').value = name;
      document.getElementById('accept_file').value = accept;
      document.getElementById('formFileButton').innerText = 'Simpan perubahan';
      document.getElementById('formFileModal').setAttribute('action', url);
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

  const deleteFile = (item) => {
      let id = item.dataset.id;
      if (confirm('Apakah kamu yakin akan menghapus data?')) {
          $.ajax({
              url: `/fileupload/${id}`,
              type: 'POST',
              data: {
                  '_method': 'DELETE',
                  '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  location.reload();
              },
              error: function(xhr, status, error) {
                  alert('File upload dipakai, tidak bisa dihapus.');
              }
          })
      }
  }
</script>