<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="300">
    <title>Jadwal Sholat</title>
</head>

<body>
    <h1>Waktu Saat Ini</h1>
    <p>Jam: <span id="clock"></span></p>
    <!-- <p>Status Mesin:</p> -->

    <script>
        function updateClock() {
            var now = new Date();
            var jam = now.getHours();
            var menit = now.getMinutes();
            var detik = now.getSeconds();
            var waktu = jam + ":" + menit + ":" + detik;
            document.getElementById("clock").innerHTML = waktu;
        }
        setInterval(updateClock, 1000);
    </script>
</body>

</html>