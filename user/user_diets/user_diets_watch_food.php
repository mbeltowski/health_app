<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");
    
    $show_food_html = '';
    if($connection){
        $user_id = $_SESSION['loged_user_id'];

        $get_food_list_SQL = "SELECT * FROM foods WHERE user_id = '$user_id'";
        $get_food_list_RESULT = $connection->query($get_food_list_SQL);
        $get_food_list_ROWS = $get_food_list_RESULT->num_rows;

        $show_food_html = '<ul class="user_food_list">';
        if($get_food_list_ROWS > 0){

            while( $row = mysqli_fetch_assoc($get_food_list_RESULT) ){
                $show_food_html .= '<li>'
                . $row['food_name'] . '
                <span class="food_info_span">
                    kcal: 
                    <span class="food_data_light">'. $row['food_calories'] . '</span>
                    białka 
                    <span class="food_data_light">'. $row['food_proteins'] . '</span>
                    tłuszcze: 
                    <span class="food_data_light">'. $row['food_fats'] . '</span>
                    cukry: 
                    <span class="food_data_light">'. $row['food_sugars'] .'</span> 
                </span>
                <a href="edit_food.php?nazwa='. $row['food_name'] .'"> edytuj </a>
                </li>';
            }
            $show_food_html .= '</ul>';
        }
    }       
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista posiłków</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="watch_food.css">
</head>
<body>
<?php
    require_once "../user_panel_navigation.php";
?>
<!-- <aside> -->
<?php
        echo $show_food_html;   
?>
<!-- </aside> -->
    <a href="user_diets_food_form.php" class="add_food_btn">Dodaj posiłek</a>
</body>
</html>