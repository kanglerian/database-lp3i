{{-- Modal Status --}}
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="programTypeModal">
  <div class="fixed inset-0 bg-black opacity-50"></div>
  <div class="fixed inset-0 flex items-center justify-center">
      <div class="w-full md:w-1/2 relative bg-white rounded-3xl shadow mx-5">
          <div class="flex items-start justify-between px-8 py-6 border-b rounded-t">
              <h3 class="text-xl font-semibold text-gray-900" id="title_programtype">
                  Tambah Tipe Program
              </h3>
              <button type="button" onclick="changeProgramTypeModal(this)" data-modal-target="programTypeModal"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                  data-modal-hide="defaultModal">
                  <i class="fa-solid fa-xmark"></i>
              </button>
          </div>
          <form method="POST" action="{{ route('programtype.store') }}" id="formProgramTypeModal">
              @csrf
              <div class="px-8 py-4 space-y-6">
                  <div>
                      <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nama
                          Program</label>
                      <input type="text" id="name_programtype" name="name" placeholder="Isi nama program disini.."
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                          required>
                  </div>
              </div>
              <div class="flex items-center px-8 py-4 space-x-2 border-t border-gray-200 rounded-b">
                  <button type="submit" id="formProgramTypeButton"
                      class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">Simpan</button>
                  <button type="button" data-modal-target="programTypeModal" onclick="changeProgramTypeModal(this)"
                      class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-xl border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
              </div>
          </form>
      </div>
  </div>
</div>
{{-- Script Status --}}
<script>
  const changeProgramTypeModal = (button) => {
      const modalTarget = button.dataset.modalTarget;
      let status = document.getElementById(modalTarget);
      let url = "{{ route('programtype.store') }}";
      document.getElementById('title_programtype').innerText = `Tambah Tipe Perogram`;
      document.getElementById('name_programtype').value = '';
      document.getElementById('formProgramTypeButton').innerText = 'Simpan';
      document.getElementById('formProgramTypeModal').setAttribute('action', url);

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

  const editProgramTypeModal = (button) => {
      const formModal = document.getElementById('formProgramTypeModal');
      const modalTarget = button.dataset.modalTarget;
      const id = button.dataset.id;
      const name = button.dataset.name;
      const accept = button.dataset.accept;
      let url = "{{ route('programtype.update', ':id') }}".replace(':id', id);
      let status = document.getElementById(modalTarget);
      document.getElementById('title_programtype').innerText = `Edit Tipe Program ${name}`;
      document.getElementById('name_programtype').value = name;
      document.getElementById('formProgramTypeButton').innerText = 'Simpan perubahan';
      document.getElementById('formProgramTypeModal').setAttribute('action', url);
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

  const deleteProgramType = (item) => {
      let id = item.dataset.id;
      if (confirm('Apakah kamu yakin akan menghapus data?')) {
          $.ajax({
              url: `/programtype/${id}`,
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

