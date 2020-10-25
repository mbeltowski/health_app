<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");

    $diets_html = '';
    if($connection){

        $user_id = $_SESSION['loged_user_id'];
        $get_diets_SQL = "SELECT * FROM diets WHERE user_id = '$user_id'";
        $get_diets_RESULT = $connection->query($get_diets_SQL); 
        //wypisać nazwe

        if( $get_diets_RESULT->num_rows > 0 ){
            while( $diet_row = mysqli_fetch_assoc($get_diets_RESULT) ){
                $diets_html .= '
                    <div class="diet_box">
                        <p>'. $diet_row['diet_name'] .'</p>
                        <a href="choose_diet.php?diet_name='. $diet_row['diet_name'] .'" class="edit_diet_btn"> Podgląd / Edytuj </a>
                    </div>
                ';
            }
        }
        else{
            $diets_html .= '
                <h2>Nie masz dodanych diet. Możesz dodać dietę.</h2>
            ';
        }
    
    }

    
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wybór diety</title>
    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="choose_diet.css">
</head>
<body>
<?php
require_once "../user_panel_navigation.php";
?>
<div class="diets_container">

<?php
    echo $diets_html;
?>
</div>
<a href="call_diet.php" class="add_diet_btn">DODAJ dietę</a>
</body>
</html>