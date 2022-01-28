<?php

//usuwanie kategorii z bazy
function UsunKategorie()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['delete_category'])) {
        $deleteCategory = $_GET['delete_category'];
        $result = mysqli_query($mysqli, "DELETE FROM kategorie WHERE id=$deleteCategory LIMIT 1");
        //header("Location: index.php");
        echo '<script type="text/javascript">
           window.location = "index.php?strona=administracja"
      </script>';

    }
}

//edycja/dodawanie kategorii do bazy danych
function EdytujKategorie()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;


    if(isset($_POST['update_category'])) {
        $id = htmlspecialchars($_POST['id']);
        $matka = htmlspecialchars($_POST['matka']);
        $nazwa = htmlspecialchars($_POST['nazwa']);

        // checking empty fields
        if(empty($nazwa)) {
            echo "<font color='red'>Nazwa jest wymagana</font><br/>";
        }
        else {
            if($id == 0) {
                $result = mysqli_query($mysqli, "INSERT INTO kategorie (matka, nazwa) VALUES ($matka, $nazwa)");
            }
            else {
                $result = mysqli_query($mysqli, "UPDATE kategorie SET matka='$matka',nazwa='$nazwa' WHERE id=$id LIMIT 1");
            }


            echo '<script type="text/javascript">
           window.location = "index.php?strona=administracja"
      </script>';



        }
    }

    $id = $_GET['id'];

//selecting data associated with this particular id
    $result = mysqli_query($mysqli, "SELECT * FROM kategorie WHERE id=$id");



    while($result && $res = mysqli_fetch_array($result)) {
        $matka = $res['matka'] ?? '';
        $nazwa = $res['nazwa'] ?? '';
    }

    if($id === null) {
        return;
    }

//    formularz dodawania/edycji kategorii
    echo '<a href="index.php?strona=administracja">Powrót</a>';
    echo '<form name="form1" method="post" action="#">';
    echo '<table border="0">';
    echo '<tr>';
    echo '<td>Matka</td>';
    echo '<td><input type="text" name="matka" value="' . $matka . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Nazwa</td>';
    echo '<td><input type="text" name="nazwa" value="' . $nazwa . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td><input type="hidden" name="id" value="' . $_GET['id'] . '"</td>';
    echo '<td><button type="submit" name="update_category">Zapisz</button></td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';

}


// wyświetlenie listy kategorii z bazy danych
function ListaKategorii()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT * FROM kategorie ORDER BY id ASC LIMIT 100");

    $start = '<div style="text-align: center"><div>
    <h3 style="text-decoration:underline;">Zarządzaj kategoriami</h3>
        <a href="?strona=administracja&showCategorySection&id=0">Dodaj</a><br/><br/>
        <table width="80%" style="margin: 0 auto; " class="tab">
        <tr style="background-color:#9E0101;color: #f8f8f8;font-weight: bold;">
            <td>Id</td>
            <td>matka</td>
            <td>nazwa</td>
            <td>Opcje</td>
        </tr>';
    $end = '</table></div></div>';

    $content = '';
    while($res = mysqli_fetch_array($result)) {
        $content .= "<tr>";
        $content .= "<td>" . $res['id'] . "</td>";
        $content .= "<td>" . $res['matka'] . "</td>";
        $content .= "<td>" . $res['nazwa'] . "</td>";
        $content .= "<td><a href=\"?strona=administracja&id=$res[id]&showCategory=true&showCategorySection=true\">Edytuj</a> | <a href=\"?strona=administracja&delete_category=$res[id]\" onClick=\"return confirm('Czy na pewno usunąć ?')\">Usuń</a></td>";
    }

    echo $start . $content . $end;
}




