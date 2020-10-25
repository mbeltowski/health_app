<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj posiłki</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="add_food.css">

    <script src="https://kit.fontawesome.com/9480ce7d31.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    require_once "../user_panel_navigation.php";
    ?>

<div class="add_food_container">
    <h2 class="food_data_info_header">Tutaj możesz dodać posiłek do listy posiłków.</h2>
    <div class="add_food_form_container">
        <form class="add_food_form" action="add_food.php" method="post">
            <h3>Dane prosze podać w przeliczeniu na 100g posiłku.</h3>

            <div class="add_food_box">
                <label for="food_name" class="add_food_label">Nazwa posiłku: </label>
                <input type="text" name="food_name" class="add_food_input" step="0.0001" required> 
            </div>

            <div class="add_food_box"> 
                <label for:="food_calories" class="add_food_label">Kalorie: </label>
                <input type="number"  name="food_calories" class="add_food_input" step="0.0001" required>
            </div>

            <div class="add_food_box">
                <label for="food_proteins" class="add_food_label">Białka: </label>
                <input type="number"  name="food_proteins" class="add_food_input" step="0.0001" required>
            </div>

            <div class="add_food_box">
                <label for="food_fats" class="add_food_label">Tłuszcze: </label>
                <input type="number"  name="food_fats" class="add_food_input" step="0.0001" required>
            </div>

            <div class="add_food_box">
                <label for="food_sugars" class="add_food_label">Cukry: </label>
                <input type="number"  name="food_sugars" class="add_food_input" step="0.0001" required>
            </div>

            <div class="add_food_error_div">
            <?php
                if(isset($_SESSION['add_food_error'])){
                    echo $_SESSION['add_food_error'];
                    unset($_SESSION['add_food_error']);
                }      
            ?>
            </div>

            
            <input type="submit" value="Dodaj" class="food_add_btn">
            
            
        </form>
    </div>
    <aside class="placehodler">
        <h2>Aktualna lista twoich posiłków:</h2>
        <?php
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
                        $show_food_html .= '<li> <a href="edit_food.php?nazwa='. $row['food_name'] .'" class="edit_icon"><i class="fas fa-edit"></i></a>'
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
                        </li>';
                    }
                    $show_food_html .= '</ul>';
                }
                echo $show_food_html;
            } 
                
        ?>
    
    </aside>
</div>
</body>
</html>
