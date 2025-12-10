// Data array
const places = [
  {
    name: "Tebet Eco Park",
    description: "Tebet Eco Park menawarkan area hijau serta ruang interaksi publik yang nyaman dan favorit untuk rekreasi dan aktivitas keluarga.",
    img: "../img/tebet-eco-park.jpg",
    alamat: "Jl. Tebet Timur Dalam II No.20, Tebet, Jakarta Selatan",
    fasilitasDifabel: ["Jalur landai", "Toilet difabel"]
  },
  {
    name: "Ragunan",
    description: "Ragunan menawarkan beragam koleksi satwa dan area hijau. Tempat ini menjadi tujuan populer untuk rekreasi keluarga.",
    img: "../img/ragunan.jpg",
    alamat: "Jl. Harsono RM No.1, Ragunan, Pasar Minggu, Jakarta Selatan",
    fasilitasDifabel: ["Toilet difabel"]

  },
  {
    name: "Hutan Kota Senayan",
    description: "Hutan Kota Senayan merupakan tempat favorit untuk rekreasi, olahraga ringan, dan berkumpul bersama komunitas.",
    img: "../img/hutan-kota-senayan.jpg",
    alamat: "Jl. Gerbang Pemuda, Gelora, Tanah Abang, Jakarta Pusat",
    fasilitasDifabel: ["Jalur landai", "Toilet difabel"]

  },
  {
    name: "Taman Literasi",
    description: "Taman Literasi adalah ruang publik yang dirancang untuk mendorong budaya baca melalui fasilitas buku, area belajar, dan spot kreatif.",
    img: "../img/taman-literasi.jpg",
    alamat: "Jl. Cikini Raya No.73, Cikini, Menteng, Jakarta Pusat",
    fasilitasDifabel: ["Jalur landai", "Toilet difabel"]

  },
  {
    name: "Gelora Bung Karno",
    description: "GBK adalah kompleks olahraga terbesar di Jakarta yang menawarkan stadion megah serta berbagai fasilitas rekreasi dan olahraga.",
    img: "../img/gbk.jpg",
    alamat: "Jl. Gerbang Pemuda, Gelora, Tanah Abang, Jakarta Pusat",
    fasilitasDifabel: ["Jalur landai", "Toilet difabel"]

  }
];

const container = document.getElementById('cardContainer');

places.forEach(place => {
  container.innerHTML += `
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="${place.img}" class="card-img-top" alt="${place.name}">
        <div class="card-body text-center">
            <h5 class="card-title">${place.name}</h5>
            <p class="card-text">${place.description}</p>
            <button class="btn btn-primary detail-btn">See Detail</button>
        </div>
      </div>
    </div>
  `;
});

// Trigger modal saat tombol diklik
document.querySelectorAll('.detail-btn').forEach((button, index) => {
  button.addEventListener('click', () => {
    const modalEl = document.getElementById('modalDetail');
    const place = places[index];
    modalEl.querySelector('.modal-title').textContent = place.name;

    const fasilitasList = place.fasilitasDifabel.map(f => `<li>${f}</li>`).join("");

    modalEl.querySelector('.modal-body').innerHTML = `
        <img src="${places[index].img}" class="img-fluid mb-3">
        <p>${places[index].description}</p>
        <p><strong>Alamat:</strong> ${places[index].alamat || 'Tidak tersedia'}</p>
        <p><strong>Fasilitas:</strong></p>
        <ul>${fasilitasList}</ul>

    `;

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  });
});

