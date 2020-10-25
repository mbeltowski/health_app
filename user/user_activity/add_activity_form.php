<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        echo $_SESSION['logedin'];
        echo $_SESSION;
        header('Location: ../../index.php');
    }

    if(!isset($_GET['data']) ){
        header('Location: user_activity_main.php');
    }
    $data = htmlentities($_GET['data']);
    echo $data;
?>
    
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodanie aktywności </title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="add_activity_form.css">
</head>
<body>

<?php 
require_once "../user_panel_navigation.php";
?>

    <form <?php echo 'action="add_activity.php?data='.$data.'"';?> method="post">
        <label for="act_title">Tytuł aktywności: </label>
        <input type="text" name="act_title" required> 
        
        <label for="act_time_start">Czas startu: [HH:MM]</label>
        <input type="time" name="act_time_start" required>

        <label for="act_time_end">Czas końca: [HH:MM]</label>
        <input type="time" name="act_time_end" required>
        
        <label for="act_description">Opis aktywności</label>
        <textarea type="text" name="act_description" required></textarea>
        
        <p class="act_form_legenda">[HH:MM] H - godziny, M - minuty</p>

        <input type="submit" value="Dodaj aktywność">
    </form> 
</body>
</html>