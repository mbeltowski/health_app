<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }
    if( !(isset($_SESSION['food_name']) && isset($_SESSION['food_calories']) && isset($_SESSION['food_proteins']) && isset($_SESSION['food_fats']) && isset($_SESSION['food_sugars'])) ){
        //przekirwoanie jezeli form nie został wysłany
        header('Location: user_diets_food_form.php');
    }
    
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");

    unset($_SESSION['add_food_error']);
    if($connection){

        $user_id = $_SESSION['loged_user_id'];
        $food_name =  $_POST['food_name'];
        $food_calories =  $_POST['food_calories'];
        $food_proteins = $_POST['food_proteins'];
        $food_fats = $_POST['food_fats'];
        $food_sugars = $_POST['food_sugars'];
        

        $check_name_SQL = "SELECT * FROM foods WHERE user_id = '$user_id' AND food_name = '$food_name' LIMIT 1";
        $check_name_RESULT = $connection->query($check_name_SQL);
        $check_name_ROWS = $check_name_RESULT->num_rows;
        
        if($check_name_ROWS > 0){
            $_SESSION['add_food_error'] = 'Posiłek o takiej naziwe już istnieje.';
            header('Location: user_diets_food_form.php');
        }
        else{
            //walidacja
            if( preg_match('/[a-zA-Z]{1,45}/', $food_name) ){
                //weight
                    //food_calories
                if( is_numeric($food_calories) ){
                    //food_proteins
                    if( is_numeric($food_proteins) ){
                        //food_fats
                        if( is_numeric($food_fats) ){
                            //food_sugars
                            if( is_numeric($food_sugars) ){
                                //!KONIEC WALIDACJI
                                $add_food_SQL = "INSERT INTO `foods` (`id_food`, `user_id`, `food_name`, `food_calories`, `food_proteins`, `food_fats`, `food_sugars`) VALUES (NULL, '$user_id', '$food_name', '$food_calories', '$food_proteins', '$food_fats', '$food_sugars')";
                                $connection->query($add_food_SQL);
                            }
                        }
                    }
                }
            }
        }
        
    }
    else {
        //brak polaczenia
    }

    header('Location: user_diets_food_form.php');
?>