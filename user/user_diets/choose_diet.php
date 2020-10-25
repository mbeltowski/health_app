<?php
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    } 

    if( !isset($_GET['diet_name']) ){
        header('Location: user_diets_main.php');
    }

    $_SESSION['diet_name'] = $_GET['diet_name'];
    header('Location: user_diets_add_diet_form.php');
?>