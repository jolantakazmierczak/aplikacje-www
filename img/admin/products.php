<?php

function UsunProdukt()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['delete_product'])) {
        $deleteProduct = $_GET['delete_product'];
        $result = mysqli_query($mysqli, "DELETE FROM produkty WHERE id=$deleteProduct LIMIT 1");
        echo '<script type="text/javascript">
           window.location = "index.php?strona=administracja"
      </script>';
    }
}
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

//
function EdytujProdukt()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;


    if(isset($_POST['update_product'])) {
        $id = htmlspecialchars($_POST['id']);
        $tytul = htmlspecialchars($_POST['tytul']);
        $opis = htmlspecialchars($_POST['opis']);
        $data_utworzenia= date('Y-m-d');
        $data_modyfikacji= date('Y-m-d');
        $data_wygasniecia= htmlspecialchars($_POST['data_wygasniecia']);
        $cena_netto = htmlspecialchars($_POST['cena_netto']);
        $podatek_vat = htmlspecialchars($_POST['podatek_vat']);
        $ilosc_dostepnych_sztuk = htmlspecialchars($_POST['ilosc_dostepnych_sztuk']);
        $kategoria= htmlspecialchars($_POST['kategoria']);
        $gabaryt= htmlspecialchars($_POST['gabaryt']);
        $status_dostepnosci = 1;

        if($ilosc_dostepnych_sztuk == 0){
            $status_dostepnosci = 0;
        }



        // checking empty fields
        if(empty($tytul) || empty($opis) || empty($data_wygasniecia) || empty($cena_netto) || empty($podatek_vat) || empty($kategoria) || empty($gabaryt)){

                echo "<font color='red'>Wszystkie pola muszą zostać wypełnione</font><br/>";

        }
        else {
            $target_dir = "uploads/";
            $fileName = generateRandomString(10);
            $target_file = $target_dir . $fileName .strstr( basename($_FILES["file"]["name"]), '.');
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
            $filePath = $target_file;
            $filePath = mysqli_escape_string($mysqli, $target_file);



            if($id == 0) {
                $result = mysqli_query($mysqli, "INSERT INTO produkty (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc_dostepnych_sztuk, status_dostepnosci, kategoria, gabaryt, zdjecie ) VALUES ($tytul, $opis,$data_utworzenia, $data_modyfikacji, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc_dostepnych_sztuk, $status_dostepnosci, $kategoria, $gabaryt, '$filePath' )");

                if(!$result) {
                    var_dump(mysqli_error($mysqli));
                }


                var_dump($result);exit;
            }
            else {
                if($_FILES["file"]["tmp_name"] != ''){
                    $result = mysqli_query($mysqli, "UPDATE produkty SET tytul='$tytul', opis='$opis', data_modyfikacji='$data_modyfikacji', data_wygasniecia='$data_wygasniecia', cena_netto=$cena_netto, podatek_vat=$podatek_vat, ilosc_dostepnych_sztuk=$ilosc_dostepnych_sztuk, status_dostepnosci=$status_dostepnosci, kategoria=$kategoria, gabaryt='$gabaryt', zdjecie='$filePath' WHERE id=$id LIMIT 1");
                }
                else{
                    $result = mysqli_query($mysqli, "UPDATE produkty SET tytul='$tytul', opis='$opis', data_modyfikacji='$data_modyfikacji', data_wygasniecia='$data_wygasniecia', cena_netto=$cena_netto, podatek_vat=$podatek_vat, ilosc_dostepnych_sztuk=$ilosc_dostepnych_sztuk, status_dostepnosci=$status_dostepnosci, kategoria=$kategoria, gabaryt='$gabaryt' WHERE id=$id LIMIT 1");
                }



            }


            echo '<script type="text/javascript">
           window.location = "index.php?strona=administracja"
      </script>';



        }
    }

    $id = $_GET['id'];


//selecting data associated with this particular id
    $result = mysqli_query($mysqli, "SELECT * FROM produkty WHERE id=$id");


    while($result && $res = mysqli_fetch_array($result)) {
        $tytul = $res['tytul'] ?? '';
        $opis = $res['opis'] ?? '';
        $data_wygasniecia= $res['data_wygasniecia'] ?? '';
        $cena_netto = $res['cena_netto'] ?? '';
        $podatek_vat = $res['podatek_vat'] ?? '';
        $ilosc_dostepnych_sztuk = $res['ilosc_dostepnych_sztuk'] ?? '';
        $kategoria= $res['kategoria'] ?? '';
        $gabaryt= $res['gabaryt'] ?? '';
        $zdjecie= $res['zdjecie'] ?? '';
        $data_modyfikacji = date('Y-m-d');
    }

    if($id === null) {
        return;
    }






    echo '<a href="index.php?strona=administracja">Powrót</a>';
    echo '<form name="form1" method="post" action="#" enctype="multipart/form-data">';
    echo '<table border="0">';
    echo '<tr>';
    echo '<td>Tytuł</td>';
    echo '<td><textarea type="text" name="tytul" rows="2"  cols="100">' . $tytul . '</textarea></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Opis</td>';
    echo '<td><textarea type="text" name="opis" rows="10"  cols="100">' . $opis . '</textarea></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<tr>';
    echo '<td>Data wygaśnięcia</td>';
    echo '<td><input type="text" name="data_wygasniecia" value="' . $data_wygasniecia . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<tr>';
    echo '<td>Cena netto</td>';
    echo '<td><input type="text" name="cena_netto" value="' . $cena_netto . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<tr>';
    echo '<td>Podatek vat</td>';
    echo '<td><input type="text" name="podatek_vat" value="' . $podatek_vat . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Ilość dostępnych sztuk</td>';
    echo '<td><input type="text" name="ilosc_dostepnych_sztuk" value="' . $ilosc_dostepnych_sztuk . '"></td>';
    echo '</tr>';
    echo '<tr>';

    echo '<td>Kategoria</td>';

    echo $kategoria;
    $tmp = 'selected=selected';
    $tmp2 = null;
//    echo '<td><input type="text" name="kategoria" value="' . $kategoria . '"></td>';

    echo '<td>';
    echo '<select name="kategoria">';

    $sql = mysqli_query($mysqli, "SELECT nazwa, id FROM kategorie where matka>0");
    while ($row = $sql->fetch_assoc()){
        if ($row['id'] == $kategoria) {
            echo '<option value="' .$row['id']. '" '. $tmp.'>' . $row['nazwa'] .'</option>';
        } else {
            echo '<option value="' .$row['id']. '">' . $row['nazwa'] .'</option>';
        }


    }
    echo '</select>';
    echo '</td>';

    echo '</tr>';
    echo '<tr>';
    echo '<td>Gabaryt</td>';
    echo '<td><input type="text" name="gabaryt" value="' . $gabaryt . '"></td>';
    echo '</tr>';
    echo '<td>Zdjęcie</td>';
    echo '<td><input type="file" name="file""></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><input type="hidden" name="id" value="' . $_GET['id'] . '"</td>';
    echo '<td><button type="submit" name="update_product">Zapisz</button></td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';

}


// --------------------
function ListaProdukt()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT * FROM produkty ORDER BY id ASC LIMIT 100");


    $start = '<div style="text-align: center; margin-top: 2rem;"><div>
    <h3 style="text-decoration:underline;">Zarządzaj produktami</h3>
        <a href="?strona=administracja&showProductSection&id=0">Dodaj</a><br/><br/>
        <table width="80%" style="margin: 0 auto;" class="tab">
        <tr style="background-color:#9E0101;color: #f8f8f8;font-weight: bold;">
            <td>Id</td>
            <td>tytul</td>
            <td>opis</td>
            <td>utworzenie</td>
            <td>modyfikacja</td>
            <td>wygasnięcie</td>
            <td>cena netto</td>
            <td>vat</td>
            <td>ilosc</td>
            <td>status</td>
            <td>kategoria</td>   
            <td>gabaryt</td> 
            <td>zdjęcie</td>
            <td>opcje</td>     
        </tr>';
    $end = '</table></div></div>';

    $content = '';
    while($res = mysqli_fetch_array($result)) {
        $content .= "<tr>";
        $content .= "<td>" . $res['id'] . "</td>";
        $content .= "<td>" . $res['tytul'] . "</td>";
        $content .= "<td>" . $res['opis'] . "</td>";
        $content .= "<td>" . $res['data_utworzenia'] . "</td>";
        $content .= "<td>" . $res['data_modyfikacji'] . "</td>";
        $content .= "<td>" . $res['data_wygasniecia'] . "</td>";
        $content .= "<td>" . $res['cena_netto'] . "</td>";
        $content .= "<td>" . $res['podatek_vat'] . "</td>";
        $content .= "<td>" . $res['ilosc_dostepnych_sztuk'] . "</td>";
        $content .= "<td>" . $res['status_dostepnosci'] . "</td>";
        $content .= "<td>" . $res['kategoria'] . "</td>";
        $content .= "<td>" . $res['gabaryt'] . "</td>";
        $content .= "<td>" . '<img src = ' . $res['zdjecie'] . ' width = "50px" height = "50px"/>'
            . '</td>' . "</td>";
        $content .= "<td><a href=\"?strona=administracja&id=$res[id]&showProduct=true&showProductSection=true\">Edytuj</a> | <a href=\"?strona=administracja&delete_product=$res[id]\" onClick=\"return confirm('Czy na pewno usunąć ?')\">Usuń</a></td>";
    }

    echo $start . $content . $end;
}




