<?php
    session_start();
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";


    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }
    if( !isset($_GET['day_nr']) || !( $_GET['day_nr'] >= 1 && $_GET['day_nr'] <= 7 ) ){
        header('Location: user_diets_add_diet_form.php');
    }

    
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");
    
    $diet_name;
    if( !isset($_POST['diet_name']) ){
        if( isset($_SESSION['diet_name']) ){
            //bierzemy z session
            $diet_name = $_SESSION['diet_name'];
        }
        else{
            header('Location: user_diets_add_diet_form.php');
        }
    }
    else{
        $diet_name = $_POST['diet_name'];
    }
    
    if( !isset($_SESSION['diet_name']) ){
        $_SESSION['diet_name'] = $diet_name;
    }



    
    $day_nr = $_GET['day_nr'];
    
    $select_html = '';
    $show_food_html = '';
    if($connection){
        // wypisz pory dla tego dnia
        
        $user_id = $_SESSION['loged_user_id'];

        //HTML DLA SELECTA ODPOWIEDZIALNEGO ZA WYBÓR JEDZENIA ------------------------------  vvvvvvvvvvvvvvvvv
        $select_option_SQL = "SELECT food_name FROM foods WHERE user_id = '$user_id'";
        $select_option_RESULT = $connection->query($select_option_SQL);
        $select_option_ROWS = $select_option_RESULT->num_rows;
    
        if($select_option_ROWS > 0){
            $select_html .= '<select name="food_name" class="food_select_input" >';
            while($row = mysqli_fetch_assoc($select_option_RESULT)){
                $select_html .= '<option value="'. $row['food_name'] .'">'. $row['food_name'] .'</option>'; 
            }
            $select_html .= '</select>
            </div>
                <div id="add_food_select_btn"> Dodaj pole wyboru potrawy + </div>
            ';
            
        }
        else{
            //nie masz
            $select_html .= '<p> nie masz </p>';

            //TODO: przekirwoanie do dodania jedzenia
        }
        //HTML DLA SELECTA ODPOWIEDZIALNEGO ZA WYBÓR JEDZENIA ------------------------------ /\/\/\/\/\/\/\

        // jezeli juz są jakieś dodane meals
        $get_diet_SQL = "SELECT * FROM diets WHERE diet_name = '$diet_name' AND user_id = '$user_id' LIMIT 1";
        $get_diet_RESULT = $connection->query($get_diet_SQL);
        $get_diet_ASSOC = $get_diet_RESULT->fetch_assoc();

        $diet_id = $get_diet_ASSOC['id_diet'];
        
        $get_meals_SQL = "SELECT * FROM meals WHERE meal_day = '$day_nr' AND diet_id = '$diet_id' ";
        $get_meals_RESULT = $connection->query($get_meals_SQL);

        while($row = mysqli_fetch_assoc($get_meals_RESULT)){
            //dla każdego rekordu wypisz

            $id_meal = $row['id_meal'];
            $meal_name = $row['meal_name'];
            $id_kolejnosc = $row['id_kolejnosc']; 

            $show_food_html .= '
                <ul class="meal_ul"> 
                <h3>'. $meal_name .'</h3>
                ';

            $get_food_SQL = "SELECT * FROM foods, food_set WHERE food_set.meal_id = '$id_meal' AND food_set.food_id = foods.id_food";

            $get_food_RESULT = $connection->query($get_food_SQL);

            while($food_row = mysqli_fetch_assoc($get_food_RESULT)){
                $show_food_html .= '
                    <li>
                    <p class="food_amount_p">'. $food_row['food_amount'] .'</p>
                    <p>'. $food_row['food_name'] .'</p>
                    <div class="food_info_box">
                        <p class="food_calories">'. $food_row['food_calories'] .'</p>
                        <p class="food_proteins">'. $food_row['food_proteins'] .'</p>
                        <p class="food_fats">'. $food_row['food_fats'] .'</p>
                        <p class="food_sugars">'. $food_row['food_sugars'] .'</p>
                    </div>
                    </li>
                ';
            }

            $show_food_html .= '
                </ul>
            ';

        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Wyświetl dzień diety</title>

     <link rel="stylesheet" href="day_view_css/style.css">
     <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
</head>
<body>
<?php
require_once "../user_panel_navigation.php";
?>
     <form 
     <?php 
     echo ' action="add_meal.php?day_nr='. $day_nr .'&diet_name='. $diet_name . '"';
    ?> 
     method="post" class="add_pora_form" style="display: none;" > 
        <div class="form_box">
            <label for="meal_name">Nazwa pory (np. śniadanie, obiad): </label>
            <input type="text" name="meal_name" required>
        </div>
        
        <div class="form_box">
        <label for="food_amount">Ilość jedzenia [ta wartość zostanie pomnożona przez 100g]: </label>
        <input type="number" name="food_amount" required step = "0.01" class="food_amount_input" value="1">
        
        <?php
            // TODO: możliwośc dodania większej ilości posiłków / jedzenia
            
            echo $select_html;

        ?>
        <br>
        <input type="submit" class="confirm_add" value="Potwierdz dodanie">
        <div class="hide_form">Ukryj</div>
        
    </form>
    
    <section class="meals_container">
    <?php
        echo $show_food_html; //!do zamiany na inną nazwę
    ?>

    <div class="summary_box"></div>
    </section>

    <button class="add_pora_dnia_btn">Dodaj porę</button>

    <?php
        echo ' <a href="user_diets_add_diet_form.php" class="back_btn"> Wróc do widoku tabeli. </a> ';
    ?>

    <script src="scripts/show_select.js">
    </script>
    <script src="scripts/show_add_pora_form.js">
    </script>
    <script src="scripts/count_meals.js">
    </script>
</body>
</html>