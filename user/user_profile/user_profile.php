<?php
    session_start();
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }
    //-----------------------------------------------
    
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą danych.");

    if(!$connection){
        // nie połączyło
        header('Location: user_panel.php');
    }
    //-----------------------------------------------------------
    $user_id = $_SESSION['loged_user_id'];
    $user_profile_SQL = "SELECT * FROM user_profile WHERE user_id = '$user_id' LIMIT 1";
    $user_profile_RESULT = @$connection->query($user_profile_SQL);
    $user_profile_ROWS = $user_profile_RESULT->num_rows;

    $is_profile_set = false;
    if($user_profile_ROWS > 0){
        //jest juz utworzony jakis profil
        $is_profile_set = true;
        $_SESSION['user_already_has_profile'] = true;
        $user_profile_ASSOC = $user_profile_RESULT->fetch_assoc();
        $wiek = $user_profile_ASSOC['profile_age'];
        $waga = $user_profile_ASSOC['profile_weight'];
        $wzrost = $user_profile_ASSOC['profile_height'];
        $plec = $user_profile_ASSOC['profile_sex'];

    }else{
        //nie ma jeszcze profilu i trzeba go utworzyć  
        $is_profile_set = false;
        $_SESSION['user_already_has_profile'] = false;

    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profli użytkownika</title>

    <link rel="stylesheet" href="../user_panel_css/user_profile.css">
    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">

    <link rel="stylesheet" href="profile_css.css">
</head>
<body>
    
 
    <div class="container">

        <?php 
        require_once "../user_panel_navigation.php";
        ?>

        <main class="profile_main">

        <div class="profile_headers">
            <h2> Profil użytkownika </h2>
            <h3> Tu znajdują się twoje podstawowe dane. </h3>
        </div>

            

            <form action="profile_save.php" method="post" class="profile_form">

                <div class="form_box">
                    <label for="age">Wiek: </label>
                    <input type="number" name="age" required <?php
                    if($is_profile_set == true){
                        echo ' value="'.$wiek.'"';
                    }
                    ?>>
                </div>
                
                <div class="form_box">
                    <label for="weight">Waga: </label>
                    <input type="number" name="weight" required <?php
                    if($is_profile_set == true){
                        echo ' value="'.$waga.'"';
                    }
                    ?>>
                </div>

                <div class="form_box">
                    <label for="height">Wzrost: </label>
                    <input type="number" name="height" required <?php
                    if($is_profile_set == true){
                        echo ' value="'.$wzrost.'"';
                    }
                    ?>>
                </div>

                <select name="sex" required class="profile_select_sex"> 
                    <option
                    <?php if($is_profile_set == true && strtoupper($plec) == "M"){
                    echo " selected ";
                    }
                    ?>
                     value="male">Mężczyzna</option>

                    <option 
                    <?php if($is_profile_set == true && strtoupper($plec) == "F"){
                        echo " selected ";
                    }
                    ?> value="female">Kobieta</option>

                    <option 
                    <?php if($is_profile_set == true && strtoupper($plec) == "O"){
                        echo " selected ";
                    }
                    ?> value="other">Nie chcę podawać / inna</option>
                </select>

                <input type="submit" value="Zapisz" class="profile_save_btn">
            </form>
        </main>
    </div>

</body>
</html>
