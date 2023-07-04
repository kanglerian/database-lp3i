const selectProvinces = document.getElementById('provinces');
const selectRegencies = document.getElementById('regencies');
const selectDistricts = document.getElementById('districts');
const selectVillages = document.getElementById('villages');

const getProvinces = async () => {
  await axios.get(`https://kanglerian.github.io/api-wilayah-indonesia/api/provinces.json`)
    .then((response) => {
      let bucket = '<option>Pilih Provinsi</option>';
      let data = response.data;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}</option>`;
      }
      document.getElementById('provinces').innerHTML = bucket;
    });
}
getProvinces();


selectProvinces.addEventListener('change', async (e) => {
  
  document.getElementById('districts').innerHTML = `<option>Pilih Kecamatan</option>`;
  document.getElementById('villages').innerHTML = `<option>Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  console.log(dataTarget);
  await axios.get(`https://kanglerian.github.io/api-wilayah-indonesia/api/regencies/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Kota / Kabupaten</option>';
      let data = response.data;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}</option>`;
      }
      document.getElementById('regencies').innerHTML = bucket;
    });
});

selectRegencies.addEventListener('change', async (e) => {

  document.getElementById('villages').innerHTML = `<option>Pilih Desa / Kelurahan</option>`;

  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`https://kanglerian.github.io/api-wilayah-indonesia/api/districts/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Kecamatan</option>';
      let data = response.data;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}</option>`;
      }
      document.getElementById('districts').innerHTML = bucket;
    });
});

selectDistricts.addEventListener('change', async (e) => {
  let dataTarget = e.target.options[e.target.selectedIndex].dataset.id;
  await axios.get(`https://kanglerian.github.io/api-wilayah-indonesia/api/villages/${dataTarget}.json`)
    .then((response) => {
      let bucket = '<option>Pilih Desa / Kelurahan</option>';
      let data = response.data;
      for (let i = 0; i < data.length; i++) {
        bucket += `<option data-id="${data[i].id}" value="${data[i].name}">${data[i].name}</option>`;
      }
      document.getElementById('villages').innerHTML = bucket;
    });
});