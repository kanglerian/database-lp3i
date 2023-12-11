const selectProvinces = document.getElementById('provinces');
const selectRegencies = document.getElementById('regencies');
const selectDistricts = document.getElementById('districts');
const selectVillages = document.getElementById('villages');

const addressContainer = document.getElementById('address-container');

const getProvinces = async () => {
  await axios.get(`/api/provinces.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let data = response.data;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}</option>`;
      }
      addressContainer.classList.remove('hidden');
      selectProvinces.innerHTML = bucket;
      if (selectProvinces.hasAttribute('disabled')) {
        selectProvinces.removeAttribute('disabled');
      }
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectProvinces.value = '';
      selectProvinces.innerHTML = bucket;
    });
}
getProvinces();


selectProvinces.addEventListener('change', async (e) => {

  selectRegencies.removeAttribute('disabled');

  if (!selectDistricts.hasAttribute('disabled')) {
    selectDistricts.setAttribute('disabled', '');
  }

  if (!selectVillages.hasAttribute('disabled')) {
    selectVillages.setAttribute('disabled', '');
  }

  selectDistricts.innerHTML = `<option>Pilih Kecamatan</option>`;
  selectVillages.innerHTML = `<option>Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/regencies/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Kota / Kabupaten</option>';
      let data = response.data;
      console.log(data);
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
        ${data[i].name}</option>`;
      }
      selectRegencies.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectRegencies.value = '';
      selectRegencies.innerHTML = bucket;
    });
});

selectRegencies.addEventListener('change', async (e) => {

  selectDistricts.removeAttribute('disabled');
  if (!selectVillages.hasAttribute('disabled')) {
    selectVillages.setAttribute('disabled', '');
  }
  selectVillages.innerHTML = `<option value="">Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/districts/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let data = response.data.districts;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
            ${data[i].name}</option>`;
      }
      selectDistricts.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectDistricts.value = '';
      selectDistricts.innerHTML = bucket;
    });
});

selectDistricts.addEventListener('change', async (e) => {

  selectVillages.removeAttribute('disabled');

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/villages/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let data = response.data.villages;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
                ${data[i].name}</option>`;
      }
      selectVillages.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillages.value = '';
      selectVillages.innerHTML = bucket;
    });
});
