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


    $list_of_activities_SQL = "SELECT * FROM user_activities WHERE user_id = '$user_id' AND activity_date = '$data'";
    $list_of_activities_RESULT =  $connection->query($list_of_activities_SQL);
    $list_of_activities_ROWS = $list_of_activities_RESULT->num_rows;
    
    $html = '<br>';
    if($list_of_activities_ROWS > 0){
 
        while($row = mysqli_fetch_assoc($list_of_activities_RESULT)){
            $html .= '
            <div class="activity">
                <div class="activity_box">
                    <span class="field_describe">Tytuł aktywności: </span> 
                    <span class="activity_value"> '.$row["activity_title"].' </span>
                </div>
                <div class="activity_box">
                    <span class="field_describe">Godzina startu aktywności: </span> 
                    <span class="activity_value">'.$row["activity_start_time"].'</span>
                </div>
                <div class="activity_box">
                    <span class="field_describe">Godzina końca aktywności: </span> 
                    <span class="activity_value">'.$row["activity_end_time"].'</span>
                </div>
                <div class="activity_box">
                    <span class="field_describe">Opis aktywności: </span> 
                    <span class="activity_value">'.$row["activity_description"].'</span>
                </div>
            </div>
            ';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawnaie aktywności</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="edit_add_activity.css">
</head>
<body>
    
<?php 
require_once "../user_panel_navigation.php";
?>

    <h1>Aktywności</h1>
    <div class="activity_container">
<?php 
    echo $html;
?>
    </div>

    <div class="activity_btns">
        <?php 
            echo '<a href="add_activity_form.php?data='.$data.'" class="add_activity_btn"> DODAJ </a>';
        ?>
        
        <a href="user_activity_main.php" class="add_activity_btn"> Wróć </a>
    </div>
    
</body>
</html>