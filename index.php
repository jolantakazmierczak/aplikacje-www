<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css?family=Lora|Ubuntu:400,700&display=swap" rel="stylesheet"/>
    <meta name="Author" content="Jolanta Kaźmierczak"/>
    <script src="https://kit.fontawesome.com/93c216d6af.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css"/>
    <title>Moje hobby to sprawy kryminalne</title>
</head>

<body>
<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
/* po tym komentarzu będzie kod do dynamicznego ładowania stron */
?>
<?php include "showpage.php"; ?>
<header>
    <div class="navbar container-flex">
        <div class="site-title">
            <h1>Historie kryminalne</h1>
            <p class="subtitle">Najciekawsze sprawy kryminalne</p>
        </div>
        <nav>
            <ul>
                <li><a href="?strona=glowna" class="current-page"> Start</a></li>
                <li><a href="?strona=articles">Artykuły</a></li>
                <li><a href="?strona=women-murderers">Kobiety zbrodni</a></li>
                <li><a href="?strona=top-ten">TOP 5 Morderców</a></li>
                <li><a href="?strona=filmy">Filmy</a></li>
                <li class="tooltip">
                    <a href="?strona=contact"><i class="fas fa-comments"></i></a>
                    <span class="tooltiptext">Kontakt</span>
                </li>
            </ul>
        </nav>
        <div class="dark-mode">
            <i title="Tryb ciemny" class="fas fa-moon"></i>
        </div>
    </div>
</header>
<div class="content">


    <?php

    $strona = $_GET['strona'];


    if (empty($strona)) {
        $strona = 'glowna';
    } else {
        printf(PokazPodstrone($strona));
    }

    ?>

</div>

<footer>
    <p><strong>Historie kryminalne</strong></p>
    <?php include 'test.php'; ?>
    <div id="clock" class="date"></div>
    <div id="date" class="date"></div>
</footer>
<script src="js/timedate.js"></script>
<script src="js/kolorujtlo.js"></script>
<script src="js/changesize.js"></script>
<script>
    $("#animacjaTestowa1").on("click", function () {
        $(this).animate({
            width: "600px",
            opacity: 0.4,
            fontSize: "5em"
        }, 1500)
    });
</script>


</body>

</html>