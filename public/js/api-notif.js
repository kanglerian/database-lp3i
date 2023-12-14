const wilayah = document.getElementById('wilayah');

const getWilayah = async () => {
  await axios.get(`${URL_API_LP3I}/region/provinces`)
    .then(() => {
      wilayah.innerHTML = '<i class="fa-solid fa-wifi text-green-500"></i>';
    })
    .catch(() => {
      wilayah.innerHTML = '<i class="fa-solid fa-wifi text-red-500"></i>';
    });
}
getWilayah();
