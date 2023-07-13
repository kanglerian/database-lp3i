const selectProvincesFather = document.getElementById('father_provinces');
const selectRegenciesFather = document.getElementById('father_regencies');
const selectDistrictsFather = document.getElementById('father_districts');
const selectVillagesFather = document.getElementById('father_villages');

const getProvincesFather = async () => {
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/provinces`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let data = response.data.provinces;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}
    </option>`;
      }
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/regencies/${dataTarget}`)
    .then((response) => {
      let bucket = '<option value="">Pilih Kota / Kabupaten</option>';
      let data = response.data.regencies;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
        ${data[i].name}</option>`;
      }
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/districts/${dataTarget}`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let data = response.data.districts;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
            ${data[i].name}</option>`;
      }
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/villages/${dataTarget}`)
    .then((response) => {
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let data = response.data.villages;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
                ${data[i].name}</option>`;
      }
      selectVillagesFather.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillagesFather.value = '';
      selectVillagesFather.innerHTML = bucket;
    });
});
