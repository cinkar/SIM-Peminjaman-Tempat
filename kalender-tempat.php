<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Peminjaman Tempat - SpaceConnect</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .title-green {
            color: rgb(37, 132, 37);
        }
        
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .footer-green {
            background-color: rgb(37, 132, 37);
        }
    </style>
</head>
<body class="bg-light">

<!-- NAVBAR -->
<?php include 'components/navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center fw-bold title-green">Kalender Peminjaman Tempat</h2>
    <p class="text-center text-muted">Klik tanggal untuk mengajukan peminjaman</p>
</div>

<div id="calendar"></div>

<div id="modalContainer"></div>

<!-- FOOTER -->
<footer class="footer-green mt-5">
    <p class="m-0 text-white text-center py-3">© 2025 SpaceConnect</p>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>

    // Simpan jadwal sementara (tanpa database dulu)
    let bookings = [];

    document.addEventListener('DOMContentLoaded', function() {

        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',

            // Klik tanggal → buka modal
            dateClick: function(info) {
                document.getElementById('date').value = info.dateStr;
                let modal = new bootstrap.Modal(document.getElementById('bookingModal'));
                modal.show();
            },

            // Load event dari array
            events: function(fetchInfo, successCallback) {
                successCallback(bookings);
            }
        });

        calendar.render();

        // Tombol simpan
        document.getElementById('saveBooking').addEventListener('click', function() {
            let date = document.getElementById('date').value;
            let nama = document.getElementById('nama').value;
            let tempat = document.getElementById('tempat').value;

            if (!nama) {
                alert("Nama wajib diisi!");
                return;
            }

            // Tambahkan ke kalender
            bookings.push({
                title: nama + " - " + tempat,
                start: date,
                color: "#0d6efd" // biru bootstrap
            });

            calendar.refetchEvents(); // refresh kalender

            document.getElementById('bookingForm').reset();
            bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
        });
    });

</script>

<script>
    fetch("form-peminjaman.html")
    .then(response => response.text())
    .then(html => {
        document.getElementById("modalContainer").innerHTML = html;
    });
</script>
</body>
</html>
