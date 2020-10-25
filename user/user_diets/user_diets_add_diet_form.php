<?php 
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }   


    $DIET_EXIST = false;
    if(!isset($_POST['diet_name'])){

        if( isset($_SESSION['diet_name']) ){
            //dieta w sesyjnej
            $DIET_EXIST = true;
        }
        else{
            header('Location: user_diets_main.php');
        }
        
    }

    $day_of_week = array("poniedzialek", "wtorek", "środa", "czwartek", "piątek", "sobota", "niedziela");

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");

    
    $main_header_html = '';
    $table_html = '';
    if($connection){
        $user_id = $_SESSION['loged_user_id'];

        $diet_name;
        if($DIET_EXIST == false){
            $main_header_html = '<h2> TWORZENIE </h2>';
            $diet_name = $_POST['diet_name'];
            
            $diet_name_SQL = "SELECT * FROM diets WHERE diet_name = '$diet_name' LIMIT 1";
            $diet_name_RESULT= $connection->query($diet_name_SQL);
            $diet_name_ROWS = $diet_name_RESULT->num_rows;

            $_SESSION['diet_name'] = $diet_name;
            unset($_POST['diet_name']);

            if($diet_name_ROWS > 0){
                //JEZELI JEST JUZ TAKA DIETA PRZEKIERUJ
                $_SESSION['diet_name'] = $diet_name;
                header('Location: user_diets_add_diet_form.php');
            }
            else{
                //JEZELI NIE MA TAKIEJ DIETY W BAZIE DODAJ JĄ
                $add_diet_SQL =  "INSERT INTO `diets` (`id_diet`, `user_id`, `diet_name`) VALUES (NULL, '$user_id', '$diet_name')";
                $connection->query($add_diet_SQL);
            }
        }
        elseif($DIET_EXIST == true){
            $main_header_html = '<h2> EDYCJA </h2>';
            $diet_name = $_SESSION['diet_name'];
        }
// ----------------------------------------------------------------
        //HTML DO TABELI Z DNIAMI TYGODNIA

// ________________________________________________
        $table_html .= '
        <h2>Jesteś w widoku tabeli: '.$diet_name.'</h2>

        <table class="diet_table">
            <tr>
        ';
        for($i = 0; $i < 7; $i++){
            $table_html .= '
                    <td>'. $day_of_week[$i] .'</td>
            ';
        }
        $table_html .= '</tr>';

// ________________________________________________

        $table_html .= '<tr>';
        for($i = 0; $i < 7; $i++){

            //sprawdz czy są już dodane meals jeżeli tak to je wypisz (jako podgląd)
            $get_diet_SQL = "SELECT * FROM diets WHERE diet_name = '$diet_name' AND user_id = '$user_id' LIMIT 1";
            $get_diet_RESULT = $connection->query($get_diet_SQL);
            $get_diet_ASSOC = $get_diet_RESULT->fetch_assoc();
    
            $diet_id = $get_diet_ASSOC['id_diet'];

            $get_meal_from_day_SQL = "SELECT * FROM meals WHERE meal_day = ". ($i+1). " AND diet_id = '$diet_id'";
            $get_meal_from_day_RESULT = $connection->query($get_meal_from_day_SQL);

            $table_html .= '<td>';
            while( $meal_row = $get_meal_from_day_RESULT->fetch_assoc() ){
                $table_html .= '
                    <ul class="meal_list"> '. $meal_row['meal_name'] .'
                ';

                $meal_id = $meal_row['id_meal'];

                $get_all_foods_from_meal_SQL = " SELECT * FROM foods, food_set WHERE food_set.meal_id = '$meal_id' AND food_set.food_id = foods.id_food AND foods.user_id = '$user_id' ";
                $get_all_foods_from_meal_RESULT = $connection->query($get_all_foods_from_meal_SQL);

                if($get_all_foods_from_meal_RESULT){
                    while( $food_row = $get_all_foods_from_meal_RESULT->fetch_assoc() ){
                        $table_html .= '
                        <li class="meal_list_item">'. $food_row['food_name'] .'</li>
                        ';
                    }
                }

                $table_html .= '
                    </ul>
                ';
            }
            $table_html .= '</td>';
        }
        $table_html .= '</td>';
// ______________________________________________________
        $table_html .= '<tr>';
        for($i = 0; $i < 7; $i++){
            //BUTTON KTÓRY PRZEKIEROWUJE DO STRONY Z WIDOKIEM DNIA, GDIZE MOZNA DODAĆ MEALS TO DAY
            $table_html .= '
                    <td><a href="user_diets_add_diet_day_view.php?day_nr='.($i+1).'&diet_name='.($diet_name).'">DODAJ</a></td>
            ';
        }
        $table_html .= '</tr>';

        $table_html .= '</table>';
    }
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj dietę!</title>
    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="add_diet_form.css">
</head>
<body>
<?php
require_once "../user_panel_navigation.php";
?>
<?php
    // WYPISANIE TABELI
    echo $main_header_html;
    echo $table_html;
?>

</body>
</html>