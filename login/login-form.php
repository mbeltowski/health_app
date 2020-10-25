<?php 
    session_start();
    require_once "../session_mgr/session_mgr.php";
    if( isset($_SESSION['logedin']) || $_SESSION['logedin'] == true ){
        header('Location: ../user/user_panel/user_panel.php');
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Logowanie</title>


    <link rel="stylesheet" href="../main_css/reg_log_style.css">
    <script src="https://kit.fontawesome.com/e4a515f5b0.js" crossorigin="anonymous"></script>
</head>
<body>
    <form class="login_form" action="login.php" method="post">
        <div class="form_box">
            <label for="login" class="red_star">Login: </label>
            <input class="type_in_input" type="text" name="login" required>
        </div>
        <div class="form_box">
            <label for="password" class="red_star">Hasło: </label>
            <div class="password_box">
                <input class="type_in_input" type="password" name="password" required>
                <div class="show_password_btn">
                    <i class="pass_visibility_icon far fa-eye" data-pass_ref_nr="1"></i>
                </div>
            </div>
        </div>

        <div class="form_box">
            <span class="login_error">
            <?php
            if(isset($_SESSION['login_error'])){
                echo $_SESSION['login_error'];
            }
            ?>
            </span>
        </div>
        <span class="reg_legend"> * - pola wymagane </span>

        <input class="login_submit" type="submit" value="Zaloguj się">
        <a href="../index.php" class="main_page_return">Wróć do strony głównej.</a>
        
    </form>

    <script src="../js/validate_reg_sc.js"></script>
</body>
</html>