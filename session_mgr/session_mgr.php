<?php
    @session_start();
    $_session_collapse_timeMINUTES = 24;

    if( isset($_SESSION['LAST_ACTIVE']) && (time() - $_SESSION['LAST_ACTIVE'] > (60 * $_session_collapse_timeMINUTES))){
        //ostatnia aktywnosc jest ustawiona, czas sesji przekroczony
            session_unset();
            session_destroy();
    }
    else{
        //trzeba ustawic ostatnia aktywnosc
        $_SESSION['LAST_ACTIVE'] = time();

        if(!isset($_SESSION['CREATED'])){
            $_SESSION['CREATED'] = time();
        }
        else if(isset($_SESSION['CREATED']) && $_SESSION['CREATED'] > (60 * $_session_collapse_timeMINUTES)){
            session_regenerate_id(true);
            $_SESSION['CREATED'] = time();
        }
    }
?>