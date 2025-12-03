<?php
require_once "../config/session.php";
checkAuth();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ketersediaan Ruangan - SIBORU</title>

    <link rel="stylesheet" href="../style.css">

    <!-- FullCalendar -->
    <link rel="stylesheet" href="../fullcalendar/fullcalendar.min.css">
    <script src="../fullcalendar/index.global.min.js"></script>

    <style>
        #calendar {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-top: 15px;
        }
        .fc {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="dashboard">

    <h2>Ketersediaan Ruangan</h2>
    <a href="dashboard.php" class="btn">Kembali</a>
    <a href="logout.php" class="logout-btn">Logout</a>

    <div class="card">
        <h3>Kalender Real-Time</h3>
        <div id="calendar"></div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 650,
        events: '../api/load_calendar.php',  // ambil dari API
        eventColor: '#007bff',
        eventTextColor: '#fff'
    });

    calendar.render();
});
</script>

</body>
</html>
