<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h3>Zastosowanie metody GET</h3>
    <form action="" method="get">
        Ulubiony kolor: <input type="text" name="color"><br>
        <input type="submit" value="Wyślij">
    </form>
</body>

</html>

<?php include 'file.php';
require_once('require.php');
$nr_indeksu = '155459';
$nrGrupy = '3';

echo 'Jolanta Kaźmierczak ' . $nr_indeksu . ' grupa ' . $nrGrupy . '<br/><br/>';



echo 'Zastosowanie metody include() <br/>';
echo 'Właśnie użyłam metody ' . $name . '<br/>';

echo '==============================================================<br/>';

echo 'Zastosowanie metody require() <br/>';
echo 'Właśnie użyłam metody ' . $name2 . '<br/>';

echo '==============================================================<br/>';

echo 'Zastosowanie if, else, elseif: <br/>';
$t = date("H");

if ($t < "10") {
    echo "Dzień dobry!";
} elseif ($t < "18") {
    echo "Miłego dnia!";
} else {
    echo "Dobry wieczór!";
}

echo '<br/>';
echo '==============================================================<br/>';

echo 'Zastosowanie switch (Wpisz kolor) <br/>';

$favcolor = $_GET["color"];

if ($favcolor != "") {
    switch ($favcolor) {
        case "czerwony":
            echo "Twój ulubiony kolor to czerwony!";
            break;
        case "niebieski":
            echo "Twój ulubiony kolor to niebieski!";
            break;
        case "zielony":
            echo "Twój ulubiony kolor to zielony!";
            break;
        default:
            echo "Twój ulubiony kolor to nie czerwony, niebieski ani zielony!";
    }
}


echo '<br/>';
echo '==============================================================<br/>';
echo 'Zastosowanie while() <br/>';
echo 'Wypisanie liczb od 1 do 5 <br/>';
$x = 1;

while ($x <= 5) {
    echo " $x, ";
    $x++;
}

echo '<br/>';
echo '==============================================================<br/>';
echo 'Zastosowanie for() <br/>';
echo 'Wypisanie liczb od 0 do 10 <br/>';



for ($x = 0; $x <= 10; $x++) {
    echo " $x, ";
}




?>