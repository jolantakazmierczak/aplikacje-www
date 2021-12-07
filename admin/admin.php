<?php


function formularzLogowania()
{
    return '
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


function edytujPodstrone()
{
    return '
        <div>
         <form action="#" method="post" ENCTYPE="multipart/form-data">

  <div class="container">
    <input type="text" placeholder="page" name="page" required>
    <textarea name="textarea" required></textarea>
    <button type="submit">Save</button>
  </div>

</form> 
</div>
        ';
}

//function listaPodstrong()
//{
//    $mysqli = getMysqli();
//
//    $query = "SELECT * FROM page_list";
//    $result = $mysqli->query($query);
//
//    $rows = [];
//    while ($row = $result->fetch_array()) {
//        $rows[] = $row;
//    }
//
//    $columns = ['id', 'page_title', 'options'];
//
//
//    echo '<table><thead><tr>';
//
//    foreach ($columns as $column) {
//        echo '<th>' . $column . '</th>';
//    }
//
//    echo '</tr></thead><tbody>';
//
//    foreach ($rows as $row) {
//        echo '<tr>';
//        foreach ($columns as $column) {
//            echo '<td>' . $row[$column] . '</td>';
//        }
//        echo "<a href="index.php?edit=<?php echo $row['id']; ?><!--" class="edit_btn" >Edit</a>";-->
<!--        echo '</tr>';-->
<!--    }-->
<!--    echo '</tbody></table>';-->

//    foreach ($rows as $row) {
//        var_dump($row['id']);
//        //var_dump($row);
//    }


<!--}-->

?>