<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if(!isset($_POST['age']) || !isset($_POST['weight']) ||!isset($_POST['height']) ||!isset($_POST['sex']) || !isset($_SESSION['user_already_has_profile']) || !isset($_SESSION['loged_user_id']) ){

        header('Location: user_profile.php');
    }

    $wiek = (int)$_POST['age'];
    $waga = (int)$_POST['weight'];
    $wzrost = (int)$_POST['height'];
    $plec = $_POST['sex'];
    $user_id = $_SESSION['loged_user_id'];

    if($wiek > 0 && $waga > 0 && $wzrost > 0){
        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą danych.");

        if($connection){
            if($_SESSION['user_already_has_profile'] == true){
                //user ma prfil >> update
                $update_profile_SQL = "UPDATE `user_profile` SET profile_age = '$wiek', profile_weight = '$waga', profile_height = '$wzrost', profile_sex = '$plec' WHERE user_id = '$user_id'";
        
                $update_profile_RESULT = $connection->query($update_profile_SQL);
                
            } 
            else{
                //trzeba zrobic profil userowi >> insert into 
                $insert_into_profile_SQL = "INSERT INTO `user_profile` VALUES (NULL, '$user_id', '$wiek', '$waga', '$wzrost', '$plec')";

                $insert_inro_profile_RESULT = $connection->query($insert_into_profile_SQL);
            }
        }
        else{
            //nie polaczono
        }
    }
    
    header('Location: user_profile.php');
?>