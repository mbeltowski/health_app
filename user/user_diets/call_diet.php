<?
    
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    if( isset($_SESSION['diet_name']) ){
        unset($_SESSION['diet_name']);
    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="call_diet.css">
</head>
<body>
    <?php
    require_once "../user_panel_navigation.php";

    echo '
    <form action="user_diets_add_diet_form.php" method="post">
        <label for="diet_name">Podaj nazwę diety którą chcesz stworzyć: </label>
        <input type="text" name="diet_name">

        <input type="submit" value="potwierdz">
    <form>';
    ?>
</body>
</html>