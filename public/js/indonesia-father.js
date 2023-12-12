const selectProvincesFather = document.getElementById('father_provinces');
const selectRegenciesFather = document.getElementById('father_regencies');
const selectDistrictsFather = document.getElementById('father_districts');
const selectVillagesFather = document.getElementById('father_villages');

const getProvincesFather = async () => {
  await axios.get(`/api/provinces.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let provinces = response.data;
      provinces.forEach(province => {
        bucket += `<option data-id="${province.id}" value="${province.name}">${province.name}</option>`;
      });
      selectProvincesFather.innerHTML = bucket;
      if (selectProvincesFather.hasAttribute('disabled')) {
        selectProvincesFather.removeAttribute('disabled');
      }
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectProvincesFather.value = '';
      selectProvincesFather.innerHTML = bucket;
    });
}
getProvincesFather();


selectProvincesFather.addEventListener('change', async (e) => {

  selectRegenciesFather.removeAttribute('disabled');

  if (!selectDistrictsFather.hasAttribute('disabled')) {
    selectDistrictsFather.setAttribute('disabled', '');
  }

  if (!selectVillagesFather.hasAttribute('disabled')) {
    selectVillagesFather.setAttribute('disabled', '');
  }

  selectDistrictsFather.innerHTML = `<option>Pilih Kecamatan</option>`;
  selectVillagesFather.innerHTML = `<option>Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/regencies/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Kota / Kabupaten</option>';
      let regencies = response.data;
      regencies.forEach(regency => {
        bucket += `<option data-id="${regency.id}" value="${regency.name}">
        ${regency.name}</option>`;
      });
      selectRegenciesFather.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectRegenciesFather.value = '';
      selectRegenciesFather.innerHTML = bucket;
    });
});

selectRegenciesFather.addEventListener('change', async (e) => {

  selectDistrictsFather.removeAttribute('disabled');
  if (!selectVillagesFather.hasAttribute('disabled')) {
    selectVillagesFather.setAttribute('disabled', '');
  }
  selectVillagesFather.innerHTML = `<option value="">Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/districts/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let districts = response.data;
      districts.forEach(district => {
        bucket += `<option data-id="${district.id}" value="${district.name}">
        ${district.name}</option>`;
      });
      selectDistrictsFather.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectDistrictsFather.value = '';
      selectDistrictsFather.innerHTML = bucket;
    });
});

selectDistrictsFather.addEventListener('change', async (e) => {

  selectVillagesFather.removeAttribute('disabled');

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/villages/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let villages = response.data;
      villages.forEach(village => {
        bucket += `<option data-id="${village.id}" value="${village.name}">
        ${village.name}</option>`;
      });
      selectVillagesFather.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillagesFather.value = '';
      selectVillagesFather.innerHTML = bucket;
    });
});

const editAddressFather = () => {
    document.getElementById('address-container-father').classList.remove('hidden');
    document.getElementById('address-content-father').classList.add('hidden');
    document.getElementById('father_address').value = null;
}
