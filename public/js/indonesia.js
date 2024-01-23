const selectProvinces = document.getElementById('provinces');
const selectRegencies = document.getElementById('regencies');
const selectDistricts = document.getElementById('districts');
const selectVillages = document.getElementById('villages');

const getProvinces = async () => {
  await axios.get(`/api/provinces.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let provinces = response.data;
      provinces.forEach(province => {
        bucket += `<option data-id="${province.id}" value="${province.name}">${province.name}</option>`;
      });
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
      let regencies = response.data;
      regencies.forEach(regency => {
        bucket += `<option data-id="${regency.id}" value="${regency.name}">
        ${regency.name}</option>`;
      });
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
      let districts = response.data;
      districts.forEach(district => {
        bucket += `<option data-id="${district.id}" value="${district.name}">
        ${district.name}</option>`;
      });
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
        console.log(response);
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let villages = response.data;
      villages.forEach(village => {
        bucket += `<option data-id="${village.id}" value="${village.name}">
        ${village.name}</option>`;
      });
      selectVillages.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillages.value = '';
      selectVillages.innerHTML = bucket;
    });
});

const editAddress = () => {
    document.getElementById('address-container').classList.remove('hidden');
    document.getElementById('address-content').classList.add('hidden');
    document.getElementById('address').value = null;
}
