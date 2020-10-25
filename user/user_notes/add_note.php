<?php
require_once "../../session_mgr/session_mgr.php";
require_once "../../connection_php/connection.php";

if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
    header('Location: ../../index.php');
}

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
$connection->set_charset("utf8");
$user_id = $_SESSION['loged_user_id'];

$today_date = date("Y-m-d H-i-s");

if($connection) {
    mysqli_query($connection, "SET character_set_results=utf8");
    
    if(isset($_POST['note_title']) && isset($_POST['note_content']) && isset($_POST['note_expire_date'])){

        $note_title = $_POST['note_title'];
        $note_content= $_POST['note_content'];
        $note_expire_date= $_POST['note_expire_date'];

        $add_note_SQL = '';
        if($note_expire_date != "0000-00-00"){
            $add_note_SQL = "INSERT INTO `notes` (`id_note`, `user_id`, `note_title`, `note_content`, `note_create_date`, `note_expiration_date`) VALUES (NULL, '$user_id', '$note_title', '$note_content', '$today_date ', '$note_expire_date')";
        }
        else{
            $add_note_SQL = "INSERT INTO `notes` (`id_note`, `user_id`, `note_title`, `note_content`, `note_create_date`, `note_expiration_date`) VALUES (NULL, '$user_id', '$note_title', '$note_content', '$today_date', NULL)";
        }
        
        $add_note_RESULT = $connection->query($add_note_SQL);
        $_SESSION['add_note_confirm'] .= "Dodano notatkę pomyślnie";
    }
    header('Location: user_notes_main.php');
}
?>