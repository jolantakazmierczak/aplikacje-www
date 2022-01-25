<?php


function cartTemplate() {

    $cart_content = pokazKoszyk();
    $sum_price = sumPrice();
    $html = <<<EOT
    <div class="cart">
        <h2>Koszyk <i class="fas fa-shopping-cart"></i></h2>
        <div class="cart-content" >
            <table style="width: 100%; padding: .5rem; text-align: center;">
                <tr>
                    <th>Zdjęcie</th>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Ilosc</th>
                    <th>Cena</th>
                    <th>Usuń</th>
                </tr>
                {$cart_content}
            </table>
            <h3>Do zapłaty: {$sum_price} zł</h3>
        </div>
        <a class="buy" href='?strona=sklep&buy' title='kup'>Kup <i class="fas fa-shopping-basket"></i></i></a>

    </div>
EOT;

    echo $html;
}

function statusChange(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT id, ilosc_dostepnych_sztuk FROM produkty");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            if($row['ilosc_dostepnych_sztuk'] == 0){
                $sql = mysqli_query($mysqli, "UPDATE produkty SET status_dostepnosci=0 WHERE id=$id; ");
            }
        }
    }

}





function buyFromCart(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    if(isset($_GET['buy'])) {
        $result = mysqli_query($mysqli, "SELECT * FROM koszyk WHERE 1");

        $koszyk = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $koszyk[] = $row;
        }


        foreach ($koszyk as $item) {
            var_dump($item);
            $iloscwkoszyku = $item['ilosc'];
            $produkt = $item['produkt'];
            $result = mysqli_query($mysqli, "UPDATE produkty SET ilosc_dostepnych_sztuk=(ilosc_dostepnych_sztuk-$iloscwkoszyku) WHERE id=$produkt; ");
            var_dump(mysqli_error($mysqli));
        }






        $result = mysqli_query($mysqli, "DELETE FROM koszyk WHERE 1");
        echo '<script type="text/javascript">
             window.location = "index.php?strona=sklep"
            </script>';

    }

}


function deleteFromCart(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $result = mysqli_query($mysqli, "DELETE FROM koszyk WHERE id=$delete LIMIT 1");
        echo '<script type="text/javascript">
           window.location = "index.php?strona=sklep"
      </script>';
    }


}


function sumPrice(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT ROUND(SUM(cena), 2) AS 'price_sum' FROM koszyk WHERE 1; ");

    $row = mysqli_fetch_assoc($result);
    $sum = $row['price_sum'];

    return $sum;
}

function recalculate(){
    echo 'hello';

}


function pokazKoszyk(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT k.id as kid, p.id as pid, p.zdjecie, p.tytul, p.id, p.opis, p.ilosc_dostepnych_sztuk, k.cena, k.ilosc FROM produkty p JOIN koszyk k ON p.id = k.produkt; ");

    //var_dump(mysqli_error($mysqli));exit;
    $wynik = '';
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {



            //var_dump($row);exit;

            $max=$row["ilosc_dostepnych_sztuk"];
            $wynik.= "
                <tr>
                    <td style='align-content: center'><img src='". $row["zdjecie"] . "' alt='' width='100px>'></td>
                    <td>" . $row["tytul"] . "</td>
                    <td>" . $row["opis"] . "</td>
                    <td>
                        <input onchange='recalculate()' type='number' name='' value='".$row["ilosc"]."' id='' style='width: 3rem;' min='0' max='" . $max . "'> / " . $row["ilosc_dostepnych_sztuk"] . "
                    </td>
                    <td>" . $row["cena"] . " zł</td>
                    <td>
                        <a href=\"?strona=sklep&delete=$row[kid]\" title='usuń'><i class='fas fa-minus fa-lg'></i></a>
                </tr>
            ";

        }
    }

    return $wynik;

}

?>

