<?php

//szablon sklepu
function template() {

    $categories = sklepKategorie();
    $products = sklepProdukty();
    $category_name = getName();
    $html = <<<EOT
     <div class="shop">
            <div class="title">
                <h1> </h1>
                <h1>SKLEP</h1>
                <a href="?strona=cart"><i class="fas fa-shopping-cart fa-2x"></i></a>
            </div>
    
            <div class="shop-content">
                <div class="categories">
                    <h3>Kategorie</h3>
                    {$categories}
                </div>
                <div class="products">
                    <h3>Produkty {$category_name} </h3>
                    <table class="products-list" style="text-align: center">
                        <tr>
                            <th></th>
                            <th>Nazwa</th>
                            <th>Opis</th>
                            <th>Ilosc</th>
                            <th>Cena</th>
                            <th></th>
                        </tr>
                        {$products}
                    </table>
    
    
                </div>
            </div>
EOT;

    echo $html;
}


// dodawanie produktów do koszyka
function addToCart(){
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['add_to_cart'])) {

        $cena_sztuka = htmlspecialchars($_GET['price']);
        $cena = $cena_sztuka;

        $prduct_id =  htmlspecialchars($_GET['add_to_cart']);
        $sql = mysqli_query($mysqli,         "SELECT id FROM koszyk WHERE produkt=$prduct_id");

        if($sql->num_rows == 0){
            $result = mysqli_query($mysqli,         "INSERT INTO koszyk (produkt, ilosc, cena) VALUES ($prduct_id,1, $cena_sztuka)");


        }
        else{
            $result = mysqli_query($mysqli,         "UPDATE koszyk SET ilosc=(ilosc+1), cena=(cena+$cena_sztuka) WHERE produkt=$prduct_id; ");
        }

        $strona = htmlspecialchars($_GET['strona']);

        if($strona == 'cart'){
            echo '<script type="text/javascript">
           window.location = "index.php?strona=cart"
      </script>';
        }

    }
}


//pobieranie nazwy otwartej kategorii
function getName(){
    $name = '';
    if(isset($_GET['show_name'])) {
        $name .= ' -> ' . $_GET['show_name'];
    }

    return $name;
}

//wyświetlenie produktów z bazy danych po danej kategorii
function sklepProdukty(){
    if(isUserLogged() === false) {
        return;
    }




    global $mysqli;

    if(isset($_GET['show_category'])) {
        $id = $_GET['show_category'];
        $sql = mysqli_query($mysqli, "SELECT * FROM produkty WHERE kategoria=$id AND status_dostepnosci=1");
    } else {
        $sql = mysqli_query($mysqli, "SELECT * FROM produkty WHERE status_dostepnosci=1");
    }


    $wynik = '';

    if (mysqli_num_rows($sql) > 0) {
        while ($row = mysqli_fetch_assoc($sql)) {

            $zm = 1 + (0.01 * $row["podatek_vat"]);
            $cena = $row["cena_netto"] * $zm;
            $wynik.= "
                    <tr>
                    
                        <td><img src='". $row["zdjecie"] . "' alt='' width='200px>'></td>
                        <td>" . $row["tytul"] . "</td>
                        <td>" . $row["opis"] . "</td>
                        <td>" . $row["ilosc_dostepnych_sztuk"] . "</td>
                        <td>" . $cena . " zł</td>
                        <td>
                            <a href=\"?strona=sklep&add_to_cart=$row[id]&price=$cena\" title='Dodaj do koszyka'><i class='fas fa-cart-plus fa-lg'></i></a>
                    </tr>
            ";

        }
    } else {
        echo "0 results";
    }

    return $wynik;


}

//wyświetlenie kategorii z bazy
function sklepKategorie(){
    if(isUserLogged() === false) {
        return;
    }


    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT id, nazwa FROM `kategorie` WHERE matka>0");

    $wynik = '';
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {

           $wynik.= "
            <ul>
                        <li>
            
                        <a href=?strona=sklep&show_category=".$row['id']."&show_name=".$row['nazwa']."  >" . $row["nazwa"] . "</a>
                        </li>

                    </ul>
            
            ";

        }
    } else {
        echo "0 results";
    }

    return $wynik;

}



?>