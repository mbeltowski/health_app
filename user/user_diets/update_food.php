<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }
    if( !(isset($_SESSION['edit_food_name']) && isset($_SESSION['food_weight']) && isset($_SESSION['food_calories']) && isset($_SESSION['food_proteins']) && isset($_SESSION['food_fats']) && isset($_SESSION['food_sugars'])) ){
        //przekirwoanie jezeli form nie został wysłany
        header('Location: user_diets_food_form.php');
    }
    
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");

    if($connection){
        $user_id = $_SESSION['loged_user_id'];
        $food_name = $_SESSION['edit_food_name'];
        unset($_SESSION['edit_food_name']);
        $food_weight = $_POST['food_weight'];
        $food_calories =  $_POST['food_calories'];
        $food_proteins = $_POST['food_proteins'];
        $food_fats = $_POST['food_fats'];
        $food_sugars = $_POST['food_sugars'];
        


        //walidacja
        if( preg_match('/[a-zA-Z]{1,45}/', $food_name) ){
            //weight
            if( is_numeric($food_weight) ){
                //food_calories
                if( is_numeric($food_calories) ){
                    //food_proteins
                    if( is_numeric($food_proteins) ){
                        //food_fats
                        if( is_numeric($food_fats) ){
                            //food_sugars
                            if( is_numeric($food_sugars) ){
                                //!KONIEC WALIDACJI
                                $add_food_SQL = "UPDATE `foods` SET `food_weight` = '$food_weight', `food_calories` = '$food_calories', `food_proteins` = '$food_proteins', `food_fats` = '$food_fats', `food_sugars` = '$food_sugars' WHERE user_id = '$user_id' AND `foods`.`food_name` = '$food_name'";
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

?>