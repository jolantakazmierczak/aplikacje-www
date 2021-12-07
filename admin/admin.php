<?php

function UsunPodstrone()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_GET['delete_id'])) {
        var_dump($_GET);
        $deleteId = $_GET['delete_id'];
        $result = mysqli_query($mysqli, "DELETE FROM page_list WHERE id=$deleteId LIMIT 1");
        //header("Location: index.php");
    }
}

function EdytujPodstrone()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;
    if(isset($_POST['update'])) {
        $id = htmlspecialchars($_POST['id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $status = htmlspecialchars($_POST['status']);

        // checking empty fields
        if(empty($title) || empty($content)) {
            if(empty($title)) {
                echo "<font color='red'>Tytuł jest wymagany</font><br/>";
            }

            if(empty($content)) {
                echo "<font color='red'>Zawartość jest wymagana</font><br/>";
            }
        }
        else {
            if(isset($_POST['status'])) {
                $status = '1';
            }
            else {
                $status = '0';
            }

            if($id == 0) {
                $result = mysqli_query($mysqli, "INSERT INTO page_list (page_title, page_content, status) VALUES ($title, $content, $status)");
            }
            else {
                $result = mysqli_query($mysqli, "UPDATE page_list SET page_title='$title',page_content='$content',status='$status' WHERE id=$id LIMIT 1");
            }

            //redirectig to the display page. In our case, it is index.php
            header("Location: index.php");
        }
    }

    $id = $_GET['id'];

//selecting data associated with this particular id
    $result = mysqli_query($mysqli, "SELECT * FROM page_list WHERE id=$id");



    while($result && $res = mysqli_fetch_array($result)) {
        $title = $res['page_title'] ?? '';
        $content = $res['page_content'] ?? '';
        $status = $res['status'] ?? '';
    }

    if($id === null) {
        return;
    }

    echo '<a href="index.php">Powrót</a>';
    echo '<form name="form1" method="post" action="#">';
    echo '<table border="0">';
    echo '<tr>';
    echo '<td>Tytuł</td>';
    echo '<td><input type="text" name="title" value="' . $title . '"></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Zawartość</td>';
    echo '<td><textarea type="text" name="content" rows="10"  cols="100">' . $content . '</textarea></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Status</td>';
    if($status == 1) {
        echo '<td><input type="checkbox" name="status" value="' . $status . '" checked="checked"></td>';
    }
    else {
        echo '<td><input type="checkbox" name="status" value="' . $status . '"></td>';
    }
    echo '</tr>';
    echo '<tr>';
    echo '<td><input type="hidden" name="id" value="' . $_GET['id'] . '"</td>';
    echo '<td><button type="submit" name="update">Zapisz</button></td>';
    echo '</tr>';
    echo '</table>';
    echo '</form>';
    echo '<hr>';
//

}

function ListPodstron()
{
    if(isUserLogged() === false) {
        return;
    }

    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT * FROM page_list ORDER BY id DESC LIMIT 100");

    $start = '<div style="text-align: center"><div>
        <a href="?id=0">Dodaj</a><br/><br/>
        <table width="80%" style="margin: 0 auto; border:1px solid;text-align:center">
        <tr bgcolor="#CCCCCC">
            <td>Id</td>
            <td>Tytuł</td>
            <td>Status</td>
            <td>Opcje</td>
        </tr>';
    $end = '</table></div></div>';

    $content = '';
    while($res = mysqli_fetch_array($result)) {
        $content .= "<tr>";
        $content .= "<td>" . $res['id'] . "</td>";
        $content .= "<td>" . $res['page_title'] . "</td>";
        $content .= "<td>" . $res['status'] . "</td>";
        $content .= "<td><a href=\"?id=$res[id]\">Edytuj</a> | <a href=\"?delete_id=$res[id]\" onClick=\"return confirm('Czy na pewno usunąć ?')\">Usuń</a></td>";
    }

    echo $start . $content . $end;
}

function isUserLogged() {
    return isset($_SESSION) && $_SESSION['valid'] === true;
}

function formularzLogowania()
{
    if(isUserLogged()) {
        return;
    }

    global $login;
    global $password;

    if(!empty($_POST['login']) && !empty($_POST['password'])) {
        if($_POST['login'] == $login && $_POST['password'] == $password) {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'tutorialspoint';

            var_dump($_SESSION);

            echo 'Poprawnie się zalogowano';
        }
        else {
            echo 'Zła nazwa użytkownika i hasło';
        }
    }

    echo '
        <div>
         <form action="' . $_SERVER['REQUEST_URI'] . '" method="post" ENCTYPE="multipart/form-data">

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" required>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
    <button type="submit">Login</button>
  </div>

</form>
</div>
        ';
}
