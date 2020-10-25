<?php 
    session_start();
    require_once "../connection_php/connection.php";
    require_once "../session_mgr/session_mgr.php";
    if( isset($_SESSION['logedin']) || $_SESSION['logedin'] == true ){
        header('Location: ../user/user_panel/user_panel.php');
    }
    if( !isset($_POST['login']) || !isset($_POST['password']) ){
        header('Location: login-form.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą danych.");



    if($connection){
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");

        $SQL_is_loggedin = "SELECT * FROM user WHERE user_login = '$login' LIMIT 1";
        $is_loggedin_RESULT = mysqli_query($connection, $SQL_is_loggedin);

        $is_loggedin_ROWS = $is_loggedin_RESULT->num_rows;

        if($is_loggedin_ROWS > 0){

            $is_loggedin_ASSOC = $is_loggedin_RESULT->fetch_assoc();
            if( password_verify($password, $is_loggedin_ASSOC['user_password']) ){
                //!zalogowano
                $_SESSION['logedin'] = true;
                $_SESSION['loged_user_id'] = $is_loggedin_ASSOC['id_user'];
                $_SESSION['user_name'] = $is_loggedin_ASSOC['user_name'];
                unset($_SESSION['login_error']);
                $connection->close();
                header('Location: ../user/user_panel/user_panel.php');
            }
            else{
                //nie ma użytkownika
                $_SESSION['login_error'] = "Nie poprawny login lub hasło1.";
                header('Location: login-form.php');
            }
        }
        else{
            //nie ma użytkownika
            $_SESSION['login_error'] = "Nie poprawny login lub hasło2.";
            header('Location: login-form.php');
        }
    }
?>