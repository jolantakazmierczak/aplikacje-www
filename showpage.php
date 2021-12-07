<?php

include "cfg.php";

function PokazPodstrone($pageTitle)
{
    $mysqli = getMysqli();

    $id_clear = htmlspecialchars($pageTitle);

    $query = "SELECT * FROM page_list WHERE page_title='$id_clear' LIMIT 1";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);

    if (empty($row['id'])) {
        $web = '[nie_znaleziono_strony]';

    } else {
        $web = $row['page_content'];

    }

    return $web;
}


?>