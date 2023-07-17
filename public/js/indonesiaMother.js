const selectProvincesMother = document.getElementById('mother_provinces');
const selectRegenciesMother = document.getElementById('mother_regencies');
const selectDistrictsMother = document.getElementById('mother_districts');
const selectVillagesMother = document.getElementById('mother_villages');

const addressMotherContainer = document.getElementById('address-mother-container');

const getProvincesMother = async () => {
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/provinces`)
    .then((response) => {
      let bucket = '<option value="">Pilih Provinsi</option>';
      let data = response.data.provinces;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}
    </option>`;
      }
      addressMotherContainer.classList.remove('hidden');
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/regencies/${dataTarget}`)
    .then((response) => {
      let bucket = '<option value="">Pilih Kota / Kabupaten</option>';
      let data = response.data.regencies;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
        ${data[i].name}</option>`;
      }
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/districts/${dataTarget}`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let data = response.data.districts;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
            ${data[i].name}</option>`;
      }
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
  await axios.get(`https://api.politekniklp3i-tasikmalaya.ac.id/region/villages/${dataTarget}`)
    .then((response) => {
      let bucket = '<option value="">Pilih Desa / Kelurahan</option>';
      let data = response.data.villages;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">
                ${data[i].name}</option>`;
      }
      selectVillagesMother.innerHTML = bucket;
    })
    .catch((err) => {
      let bucket = `<option value="">${err.message}</option>`;
      selectVillagesMother.value = '';
      selectVillagesMother.innerHTML = bucket;
    });
});
