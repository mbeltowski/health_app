<?php
require_once "../../session_mgr/session_mgr.php";
require_once "../../connection_php/connection.php";

if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
    header('Location: ../../index.php');
}

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");

$daily_hint_html = '';
if($connection)
{
    mysqli_query($connection, "SET character_set_results=utf8");
    
    $user_id = $_SESSION['loged_user_id'];
    $today_date = date("Y-m-d");

    //pobiera last_hint_date
    $is_it_high_noon_SQL = "SELECT * FROM user WHERE id_user = '$user_id' LIMIT 1 ";
    $is_it_high_noon_RESULT = $connection->query($is_it_high_noon_SQL);
    $is_it_high_noon_ASSOC = mysqli_fetch_assoc($is_it_high_noon_RESULT);

    if($today_date > $is_it_high_noon_ASSOC['last_hint_date']){

        $get_max_SQL = "SELECT MAX(id_hint) as max FROM daily_hints";
        $get_max_RESULT = $connection->query($get_max_SQL);
        $get_max_ASSOC = mysqli_fetch_assoc($get_max_RESULT);
        $max = $get_max_ASSOC['max'];
        $hint_id = random_int(1, (int)$max-1);
        

        //sprawdz czy user nie mial dzien wczesniej takiego hinta
        $check_hint_id_SQL = "SELECT * FROM user WHERE last_hint_id = '$hint_id'";
        $check_hint_id_RESULT = $connection->query($check_hint_id_SQL);
        $check_hint_id_ROWS = $check_hint_id_RESULT->num_rows;
        if($check_hint_id_ROWS > 0){
            $hint_id += 1;
        }
    
        //pobierz hinta
        $get_hint_SQL = "SELECT * FROM daily_hints WHERE id_hint = '$hint_id' LIMIT 1";
        $get_hint_RESULT = $connection->query($get_hint_SQL);
        $get_hint_ASSOC = mysqli_fetch_assoc($get_hint_RESULT);
    
        //update user rekord
        $update_user_last_hint_SQL = "UPDATE user SET last_hint_id = '$hint_id', last_hint_date = '$today_date' WHERE id_user = '$user_id'";
        $update_user_last_hint_RESULT = $connection->query($update_user_last_hint_SQL);
    
        $daily_hint_html = '
        <div class="daily_hint_container">
            <h2 class="daily_hint_dh"> Daily hint </h2>
            <h2 class="daily_hint_title">'. $get_hint_ASSOC['hint_title'] .'</h2>
            <p class="daily_hint_content">'. $get_hint_ASSOC['hint_content'] .'</p>
            <button class="daily_hint_hide">ok!</button>
            <p>'.$today_date.'</p>
        </div>
        ';
    }
    elseif($today_date = $is_it_high_noon_ASSOC['last_hint_date']){
        //pobierz today_hint_id i wyświetl
        $today_hint_id = $is_it_high_noon_ASSOC['last_hint_id'];
        //pobierz hinta
        $get_hint_SQL = "SELECT * FROM daily_hints WHERE id_hint = '$today_hint_id' LIMIT 1";
        $get_hint_RESULT = $connection->query($get_hint_SQL);
        $get_hint_ASSOC = mysqli_fetch_assoc($get_hint_RESULT);

        $daily_hint_html = '
        <div class="daily_hint_container">
            <h2 class="daily_hint_dh"> Daily hint </h2>
            <h2 class="daily_hint_title">'. $get_hint_ASSOC['hint_title'] .'</h2>
            <p class="daily_hint_content">'. $get_hint_ASSOC['hint_content'] .'</p>
            <button class="daily_hint_hide">ok!</button>
            <p>'.$today_date.'</p>
        </div>
        ';
    }
}

?>