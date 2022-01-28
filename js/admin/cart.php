<?php

//szablon koszyka
function cartTemplate() {

    $cart_content = pokazKoszyk();
    $sum_price = sumPrice();
    $html = <<<EOT
    <div class="cart">
        <h2>Koszyk <i class="fas fa-shopping-cart"></i></h2>
        <div class="cart-content" >
            <table style="width: 100%; padding: .5rem; text-align: center;">
                {$cart_content}
            </table>
            <h3>Do zapłaty: {$sum_price} zł</h3>
        </div>
        <br>
        <a class="buy" href='?strona=cart&buy' title='kup'>Kup <i class="fas fa-shopping-basket"></i></a>
        <br><br><br><br>

    </div>
EOT;

    echo $html;
}

//funkcja sprawdzająca ilość dostępnych produktów w bazie i zmieniająca status, gdy ilość produktów wynosi 0
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



//funkcja usuwająca produkty z koszyka po zakupie produktów oraz zmniejszająca ilość produktów w tabeli produkty

function buyFromCart(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    if(isset($_GET['buy'])) {
        $result = mysqli_query($mysqli, "SELECT * FROM koszyk");

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






        $result = mysqli_query($mysqli, "DELETE FROM koszyk");
        echo '<script type="text/javascript">
             window.location = "index.php?strona=cart"
            </script>';

    }

}

//funkcja usuwająca wybrany produkt z koszyka
function deleteFromCart(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['delete'])) {
        $delete = $_GET['delete'];
        $result = mysqli_query($mysqli, "DELETE FROM koszyk WHERE id=$delete LIMIT 1");
        echo '<script type="text/javascript">
           window.location = "index.php?strona=cart"
      </script>';
    }


}

//funkcja wyliczająca sumę cen produktów w koszyku
function sumPrice(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT ROUND(SUM(cena), 2) AS 'price_sum' FROM koszyk; ");

    $row = mysqli_fetch_assoc($result);

    if($row['price_sum'] == null){
        $sum = 0;
    }
    else{
        $sum = $row['price_sum'];
    }


    return $sum;
}

function minusCart() {

    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['minus'])) {

        $cena_sztuka = htmlspecialchars($_GET['minus_cena']);

        $product_id =  htmlspecialchars($_GET['minus']);



        $result = mysqli_query($mysqli,         "UPDATE koszyk SET ilosc=(ilosc-1), cena=(cena-$cena_sztuka) WHERE produkt=$product_id; ");

        $sql = mysqli_query($mysqli,         "SELECT ilosc FROM koszyk WHERE produkt=$product_id");


        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_assoc($sql)) {
                if($row['ilosc'] == "0"){
                    $del = mysqli_query($mysqli, "DELETE FROM koszyk WHERE produkt=$product_id;");
                }
            }
        }



        echo '<script type="text/javascript">
           window.location = "index.php?strona=cart"
      </script>';
    }




}


//wyświetlenie produktów w koszyku
function pokazKoszyk(){
    if(isUserLogged() === false) {
        return;
    }



    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT k.id as kid, p.id as pid, p.zdjecie, p.tytul, p.id, p.opis, p.ilosc_dostepnych_sztuk, k.cena, k.ilosc FROM produkty p JOIN koszyk k ON p.id = k.produkt; ");

    //var_dump(mysqli_error($mysqli));exit;
    $wynik = '
        <tr>
                    <th>Zdjęcie</th>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Ilosc</th>
                    <th>Cena</th>
                    <th>Usuń</th>
                </tr>
    
    ';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $price = $row["cena"] / ($row["ilosc"] == 0 ? 1 : $row["ilosc"]);
            $wynik.= "
                <tr>
                    <td style='align-content: center'><img src='". $row["zdjecie"] . "' alt='' width='100px>'></td>
                    <td>" . $row["tytul"] . "</td>
                    <td>" . $row["opis"] . "</td>
                    <td style='align-content: center'>
                        
                        <div class='rowTable'>
                            ".$row["ilosc"]." / " . $row["ilosc_dostepnych_sztuk"] . " 
                            <span class='col'>
                                <a href=\"?strona=cart&add_to_cart=$row[pid]&price=$price\" title='dodaj'><i class='fas fa-chevron-up'></i></a>
                                <a href=\"?strona=cart&minus=$row[pid]&minus_cena=$price\" title='usuń'><i class='fas fa-chevron-down'></i></a>
    
                            </span>
                        
                        </div>


                    </td>
                    <td>" . $row["cena"] . " zł</td>
                    <td>
                        <a href=\"?strona=cart&delete=$row[kid]\" title='usuń'><i class='fas fa-minus fa-lg'></i></a>
                </tr>
            ";


        }
    }else {
        $wynik="<h3>Twój koszyk jest pusty </h3>";
    }

    return $wynik;

}

?>

