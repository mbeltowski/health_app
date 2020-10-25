<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    // musi być ustawiony dzień diety oraz jej nazwa, i zmienne z posta
    if( !isset($_GET['diet_name']) || !isset($_GET['day_nr']) ){
        header('user_diets_main.php');
    }

    if( !isset($_POST['meal_name']) || !isset($_POST['food_name']) ){
        header('user_diets_main.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
    $connection->set_charset("utf8");

    if($connection){
        $user_id = $_SESSION['loged_user_id'];
        $diet_name = $_GET['diet_name'];
        $day_nr = $_GET['day_nr'];
        $meal_name = $_POST['meal_name'];
        $food_name = $_POST['food_name'];
        $food_amount = $_POST['food_amount'];

        $get_diet_SQL = "SELECT * FROM diets WHERE diet_name = '$diet_name' AND user_id = '$user_id' LIMIT 1";
        $get_diet_RESULT = $connection->query($get_diet_SQL);
        $get_diet_ASSOC = $get_diet_RESULT->fetch_assoc();

        $diet_id = $get_diet_ASSOC['id_diet'];

        //jeżeli tylko jeden food

        //TODO: dodać validację!!!!!!!!
        if( preg_match( '/[a-zA-Z0-9]{1,30}/', $meal_name )){
            $insert_meals_SQL = "INSERT INTO `meals` (`id_meal`, `diet_id`, `meal_day`, `meal_name`, `meal_kolejnosc`) VALUES (NULL, '$diet_id', '$day_nr', '$meal_name', '1')";
            $insert_meals_RESULT = $connection->query($insert_meals_SQL);

            $id_meal_SQL = "SELECT * FROM meals WHERE diet_id = '$diet_id' AND meal_day = '$day_nr' AND meal_name = '$meal_name'";
            $id_meal_RESULT = $connection->query($id_meal_SQL);
            $meal_id = $id_meal_RESULT->fetch_assoc()['id_meal'];

            $id_food_SQL = "SELECT * FROM foods WHERE user_id = '$user_id' AND food_name = '$food_name' LIMIT 1";
            $id_food_RESULT = $connection->query($id_food_SQL);
            $food_id = $id_food_RESULT->fetch_assoc()['id_food'];

            // "INSERT INTO `food_set` (`id_fset`, `meal_id`, `food_id`) VALUES (NULL, '', '')"
            $insert_food_set_SQL = "INSERT INTO `food_set` (`id_fset`, `meal_id`, `food_id`, `food_amount`) VALUES (NULL, '$meal_id', '$food_id', '$food_amount')";
            $insert_food_set_RESULT = $connection->query( $insert_food_set_SQL);
        }

        if(isset($_POST['food_name2'])){
            $ilosc_mozliwych_selectow = 5;

            for($i = 2; $i <= $ilosc_mozliwych_selectow; $i++){

                if( isset($_POST['food_name' . $i]) ){
                    $food_name = $_POST['food_name' . $i];
                    $food_amount = $_POST['food_amount' . $i];

                    if($food_amount <= 0 ){
                        $food_amount = 1;
                    }
    
                    if( preg_match( '/[a-zA-Z0-9]{1,30}/', $meal_name )){
                        //pobranie $meal_id i $food_id
                        $id_meal_SQL = "SELECT * FROM meals WHERE diet_id = '$diet_id' AND meal_day = '$day_nr' AND meal_name = '$meal_name'";
                        $id_meal_RESULT = $connection->query($id_meal_SQL);
                        $meal_id = $id_meal_RESULT->fetch_assoc()['id_meal'];
            
                        $id_food_SQL = "SELECT * FROM foods WHERE user_id = '$user_id' AND food_name = '$food_name' LIMIT 1";
                        $id_food_RESULT = $connection->query($id_food_SQL);
                        $food_id = $id_food_RESULT->fetch_assoc()['id_food'];
            
                        // "INSERT INTO `food_set` (`id_fset`, `meal_id`, `food_id`) VALUES (NULL, '', '')"
                        $insert_food_set_SQL = "INSERT INTO `food_set` (`id_fset`, `meal_id`, `food_id`, `food_amount`) VALUES (NULL, '$meal_id', '$food_id', '$food_amount')";

                       // INSERT INTO `food_set` (`id_fset`, `meal_id`, `food_id`, `food_amount`) VALUES (NULL, '', '', '1')
                        $insert_food_set_RESULT = $connection->query( $insert_food_set_SQL);
                    }
                }
            }
        }
        header("Location: user_diets_add_diet_day_view.php?day_nr=". $day_nr ."&diet_name=". $diet_name);
    }
?>