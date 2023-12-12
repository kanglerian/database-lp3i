const selectProvincesMother = document.getElementById('mother_provinces');
const selectRegenciesMother = document.getElementById('mother_regencies');
const selectDistrictsMother = document.getElementById('mother_districts');
const selectVillagesMother = document.getElementById('mother_villages');

const getProvincesMother = async () => {
  await axios.get(`/api/provinces.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let provinces = response.data;
      provinces.forEach(province => {
        bucket += `<option data-id="${province.id}" value="${province.name}">${province.name}</option>`;
      });
      selectProvincesMother.innerHTML = bucket;
      if (selectProvincesMother.hasAttribute('disabled')) {
        selectProvincesMother.removeAttribute('disabled');
      }
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectProvincesMother.value = '';
      selectProvincesMother.innerHTML = bucket;
    });
}

getProvincesMother();

selectProvincesMother.addEventListener('change', async (e) => {

  selectRegenciesMother.removeAttribute('disabled');

  if (!selectDistrictsMother.hasAttribute('disabled')) {
    selectDistrictsMother.setAttribute('disabled', '');
  }

  if (!selectVillagesMother.hasAttribute('disabled')) {
    selectVillagesMother.setAttribute('disabled', '');
  }

  selectDistrictsMother.innerHTML = `<option>Pilih Kecamatan</option>`;
  selectVillagesMother.innerHTML = `<option>Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/regencies/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Kota / Kabupaten</option>';
      let regencies = response.data;
      regencies.forEach(regency => {
        bucket += `<option data-id="${regency.id}" value="${regency.name}">
        ${regency.name}</option>`;
      });
      selectRegenciesMother.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectRegenciesMother.value = '';
      selectRegenciesMother.innerHTML = bucket;
    });
});

selectRegenciesMother.addEventListener('change', async (e) => {

  selectDistrictsMother.removeAttribute('disabled');
  if (!selectVillagesMother.hasAttribute('disabled')) {
    selectVillagesMother.setAttribute('disabled', '');
  }
  selectVillagesMother.innerHTML = `<option value="">Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/districts/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let districts = response.data;
      districts.forEach(district => {
        bucket += `<option data-id="${district.id}" value="${district.name}">
        ${district.name}</option>`;
      });
      selectDistrictsMother.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectDistrictsMother.value = '';
      selectDistrictsMother.innerHTML = bucket;
    });
});

selectDistrictsMother.addEventListener('change', async (e) => {

  selectVillagesMother.removeAttribute('disabled');

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`/api/villages/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let villages = response.data;
      villages.forEach(village => {
        bucket += `<option data-id="${village.id}" value="${village.name}">
        ${village.name}</option>`;
      });
      selectVillagesMother.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillagesMother.value = '';
      selectVillagesMother.innerHTML = bucket;
    });
});

const editAddressMother = () => {
    document.getElementById('address-container-mother').classList.remove('hidden');
    document.getElementById('address-content-mother').classList.add('hidden');
    document.getElementById('mother_address').value = null;
}
