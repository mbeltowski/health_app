<?php
require_once "../../session_mgr/session_mgr.php";
require_once "../../connection_php/connection.php";

if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
    header('Location: ../../index.php');
}

if(!isset($_GET['data']) ){
    header('Location: user_activity_main.php');
}

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą danych.");

//!zabezpieczyć
$data = htmlentities($_GET['data']);
$user_id = $_SESSION['loged_user_id'];

$html = '';
if($connection){
    if( isset($_POST['act_title']) &&  isset($_POST['act_time_start']) && isset($_POST['act_time_end']) && isset($_POST['act_description'])){
        //form został wysłany można odać rekord, a najpierw GO ZWALIDOWAĆ

        $title = $_POST['act_title'];
        $time_start = $_POST['act_time_start'];
        $time_end = $_POST['act_time_end'];
        $act_desc= $_POST['act_description'];

        if( preg_match('/[a-zA-Z0-9]{1,30}/', $title) ){
            if( preg_match('/^([0-9]{2}):([0-9]{2})/', $time_start) ){
                if( preg_match('/^([0-9]{2}):([0-9]{2})/', $time_end) ){
                    if( preg_match('/[a-zA-Z0-9]{1,300}/', $act_desc) ){
                        //!walidacja zakończona poprawnie
                            
                        $add_activity_SQL = "INSERT INTO `user_activities` (`id_activity`, `user_id`, `activity_date`, `activity_title`, `activity_start_time`, `activity_end_time`, `activity_description`) VALUES (NULL, '$user_id', '$data', '$title', '$time_start', '$time_end', '$act_desc')";
                        
                        $connection->query($add_activity_SQL);
                        $html = 'Pomyślnie dodano aktywność! <a href="user_activity_main.php" class="return_activity_main_btn"> Wróć do strony głównej aktywności. </a>';
                    }
                }
            }
        }
    }
}
    
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktywność dodana!</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="add_activity_form.css">
</head>
<body>
<?php 
require_once "../user_panel_navigation.php";
?>

    <? if($html != '') echo $html; ?>
</body>
</html>