// Data array
const places = [
  {
    name: "Tebet Eco Park",
    description: "Tebet Eco Park menawarkan area hijau serta ruang interaksi publik yang nyaman dan favorit untuk rekreasi dan aktivitas keluarga.",
    img: "../img/tebet-eco-park.jpg"
  },
  {
    name: "Ragunan",
    description: "Ragunan menawarkan beragam koleksi satwa dan area hijau. Tempat ini menjadi tujuan populer untuk rekreasi keluarga.",
    img: "../img/ragunan.jpg"
  },
  {
    name: "Hutan Kota Senayan",
    description: "Hutan Kota Senayan merupakan tempat favorit untuk rekreasi, olahraga ringan, dan berkumpul bersama komunitas.",
    img: "../img/hutan-kota-senayan.jpg"
  },
  {
    name: "Taman Literasi",
    description: "Taman Literasi adalah ruang publik yang dirancang untuk mendorong budaya baca melalui fasilitas buku, area belajar, dan spot kreatif.",
    img: "../img/taman-literasi.jpg"
  },
  {
    name: "Gelora Bung Karno",
    description: "GBK adalah kompleks olahraga terbesar di Jakarta yang menawarkan stadion megah serta berbagai fasilitas rekreasi dan olahraga.",
    img: "../img/gbk.jpg"
  }
];

const container = document.getElementById("cardContainer");

// Loop data dan buat card otomatis
places.forEach(place => {
  container.innerHTML += `
    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <img src="${place.img}" class="card-img-top" alt="${place.name}">
        <div class="card-body text-center">
            <h5 class="card-title">${place.name}</h5>
            <p class="card-text">${place.description}</p>
            <div class="d-flex justify-content-center">
                <a href="#" class="btn btn-primary">Detail</a>
            </div>

        </div>
      </div>
    </div>
  `;
});
