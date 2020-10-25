<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";


    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    if(!isset($_GET['nazwa'])){
        header('Location: user_died_watch_food.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Nie połączono z bazą.");
    $connection->set_charset("utf8");

    if($connection){
        
    
        $GET_name =  htmlentities($_GET['nazwa']);
        $user_id = $_SESSION['loged_user_id'];


        $get_food_SQL = "SELECT * FROM foods WHERE user_id = '$user_id' AND food_name = '$GET_name' LIMIT 1";
        $get_food_RESULT = $connection->query($get_food_SQL);
        $get_food_ROWS = $get_food_RESULT->num_rows;
        
        if($get_food_ROWS > 0){
            
            $get_food_ASSOC = mysqli_fetch_assoc($get_food_RESULT);

            $calories =  $get_food_ASSOC['food_calories'];
            $proteins = $get_food_ASSOC['food_proteins'];
            $fats = $get_food_ASSOC['food_fats'];
            $sugars = $get_food_ASSOC['food_sugars'];
        }
        

    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDYTUJ PAPU</title>
</head>
<body>
<form action="update_food.php" method="post">
        
        <div class="add_food_container">
            <div class="add_food_box">
                <p class="food_name_const">Nazwa edytowanego posiłku: <?php
                    echo $GET_name;
                    $_SESSION['edit_food_name'] = $GET_name;
                ?> </p>
            </div>

            <div class="add_food_box"> 
                <label for:="food_calories" class="add_food_label">Kalorie: </label>
                <input type="number"  name="food_calories" class="add_food_input" step="0.0001" required <?php
                    echo ' value="'. $calories .'" ';
                ?>>
            </div>

            <div class="add_food_box">
                <label for="food_proteins" class="add_food_label">Białka: </label>
                <input type="number"  name="food_proteins" class="add_food_input" step="0.0001" required <?php
                    echo ' value="'. $proteins .'" ';
                ?>>
            </div>

            <div class="add_food_box">
                <label for="food_fats" class="add_food_label">Tłuszcze: </label>
                <input type="number"  name="food_fats" class="add_food_input" step="0.0001" required <?php
                    echo ' value="'. $fats .'" ';
                ?>>
            </div>

            <div class="add_food_box">
                <label for="food_sugars" class="add_food_label">Cukry: </label>
                <input type="number"  name="food_sugars" class="add_food_input" step="0.0001" required <?php
                    echo ' value="'. $sugars .'" ';
                ?>>
            </div>

        </div>

        <input type="submit" value="Edytuj" class="food_add_btn">

    </form>
</body>
</html>