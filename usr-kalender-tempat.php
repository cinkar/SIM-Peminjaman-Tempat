<?php
$query = "SELECT namaFasilitas, tanggalMulai, tanggalSelesai, waktuMulai, waktuSelesai FROM reservasi";
$result = mysqli_query($conn, $query);

$events = [];

while ($row = mysqli_fetch_assoc($result)) {
    $start = $row['tanggalMulai'].'T'.$row['waktuMulai'];
    $end   = $row['tanggalSelesai'].'T'.$row['waktuSelesai'];

    if (stripos($row['namaFasilitas'], 'aula') !== false) {
        $color = '#dc3545'; // merah
    } else {
        $color = '#0d6efd'; // default
    }

    $events[] = [
        'title' => $row['namaFasilitas'],
        'start' => $start,
        'end'   => $end,
        'color' => $color
    ];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Peminjaman Tempat</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 15px;
        }
    </style>

    <link rel="stylesheet" href="navbar.css">
    
</head>
<body class="bg-light">
    <div id="navbar"></div>

    <div class="container mt-4">
        <h2 class="text-center fw-bold">Kalender Peminjaman Tempat</h2>
        <p class="text-center text-muted">Klik tanggal untuk mengajukan peminjaman</p>
    </div>

    <div id="calendar"></div>

    <div id="modalContainer"></div>



    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
    const bookings = <?= json_encode($events); ?>;
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: bookings
    });

    calendar.render();
});
</script>


    <script>
        fetch("components/navbar.html")
            .then(res => res.text())
            .then(data => {
                document.getElementById("navbar").innerHTML = data;
            });
    </script>

    <script>
        fetch("form-peminjaman.php")
        .then(response => response.text())
        .then(html => {
            document.getElementById("modalContainer").innerHTML = html;
        });
    </script>
</body>
</html>
