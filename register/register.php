<?php

    if(
        !isset($_POST['name']) || !isset($_POST['surname']) || !isset($_POST['email']) || !isset($_POST['login']) || !isset($_POST['password']) || !isset($_POST['password2']) || !isset($_POST['country'])
    ){
        header('Location: register-form.php');
    }

    session_start();
    require_once "../session_mgr/session_mgr.php";


    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $nickname = $_POST['nickname'];
    $password1 = $_POST['password'];
    $password2 = $_POST['password2'];
    $country = $_POST['country']; 

    $_SESSION['name'] = $name;
    $_SESSION['surname'] = $surname;
    $_SESSION['email'] = $email;
    $_SESSION['login'] = $login;
    $_SESSION['nickname'] = $nickname;

    require_once "../connection_php/connection.php";
    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name)
    or die("Błąd połaczenia z bazą danych.");

    //CAPTCHA
		$captcha_secret = "6LfOQtUZAAAAAPrw0rgqVmnxAYtznO5p9hhDs6EB";
		
		$captcha_valid_result = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$captcha_secret.'&response='.$_POST['g-recaptcha-response']);
		
		$response = json_decode($captcha_valid_result);
        

        if(isset($_SESSION['val_error'])){
            unset($_SESSION['val_error']);
        }

		if ($response->success==true)
		{
            // val imie
            if(preg_match('/[a-zA-Z]{2,30}/', $name )){
                // val nazwisko
                if(preg_match('/[a-zA-Z]{2,30}/',$surname)){
                    // val email
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        //VAL LOGIN
                        if(preg_match('/[a-zA-Z0-9]{6,20}/',$login)){
                            //VAL_PASS_MATCH
                            if($password1 == $password2){
                                //VAL_PASS_VALID_LENGTH
                                if(strlen($password1) > 7 && strlen($password1) < 30){

                                    // sprawdz czy ten email nie jest uzyty
                                    
                                    $sql_val_mail = "SELECT * FROM user WHERE user_email = '$email'";
                                    $mail_val_result = mysqli_query($connection, $sql_val_mail);
                                    $val_email_nr_rows =  mysqli_num_rows($mail_val_result);

                                    if($val_email_nr_rows > 0){
                                        //taki email jest uzyty
                                        $_SESSION['val_error'] = "Istnieje już konto z takim e-mailem.";
                                    }
                                    else {

                                        //sprawdz czy nie ma takiego usera
                                        $sql_val_login = "SELECT * FROM user WHERE user_login = '$login'";
                                        $login_val_result = mysqli_query($connection, $sql_val_login);
                                        $val_login_nr_rows = mysqli_num_rows($login_val_result);
                                        
                                        if($val_login_nr_rows > 0){
                                            //mamy problem ten user istnieje
                                            $_SESSION['val_error'] = "Login jest już zajęty.";
                                        }
                                        else{
                                            //mozna utworzyc usera
                                            //!WALIDACJA ZAKONCZONA

                                            $password1 = htmlentities($password1, ENT_QUOTES, "UTF-8");
                                            $password_hashed = password_hash($password1, PASSWORD_DEFAULT);
                                            $login = htmlentities($login, ENT_QUOTES, "UTF-8");
                                            //$ver_key = md5(time().$nickname);
                                            //do weryfikacji maila
                                            
                                            $add_user_sql = "INSERT INTO `user` (`id_user`, `user_login`, `user_password`, `user_email`, `user_name`, `user_surename`, `user_nickname`, `user_register_date`, `user_country`, `ver_key`, `verified`) VALUES (NULL, '$login', '$password_hashed', '$email', '$name', '$surname', ' $nickname', now(), '$country', '$ver_key', 0)";
                                            //INSERT INTO `user` (`id_user`, `user_login`, `user_password`, `user_email`, `user_name`, `user_surename`, `user_nickname`, `user_register_date`, `user_country`, `ver_key`, `verified`) VALUES (NULL, '1', '1', '1', '1', '1', '1', '1', '1')

                                            $add_user_result = mysqli_query($connection, $add_user_sql);
                                            // !DODANO UŻYTKOWNIKA

                                            $connection->close();
                                            header('Location: ../user/user_panel/user_panel.php');
                                            //weryfikacja maila - wyslanie
                                            /* if($add_user_result){
                                                $subject = "Weryfikacja adresu email";
                                                $adres_strony_veryfikacyjnej = "http://2fg.fun/beltowski/Health%20App/register/verify.php";
                                                $message = '<a href="'.
                                                $adres_strony_veryfikacyjnej.
                                                '?vkey='.
                                                $ver_key.
                                                '">Potwierdź swój adres e-mail</a>';
                                                $headers = "From: beltowski@2fg.fun \r\n";
                                                $headers .= "MIME-VERSION: 1.0" . "\r\n";
                                                $headers .= "Content-type:text/html;charset=URF-8"."\r\n";
    
                                                mail($email, $subject, $message, $headers);
                                                header("Location: thank_you.php");
                                            } */
                                        }
                                    }
                                }
                                else{
                                    $_SESSION['val_error'] = "Hasło powinno zawierać od 8 do 30.";
                                }                              
                            }
                            else{
                                $_SESSION['val_error'] = "Hasła nie pasują do siebie.";
                            }
                        }
                        else{
                            $_SESSION['val_error'] = "Nie poprawny login. Może zawierać litery i cyfry. Od 6 20";
                        }
                    } 
                    else{
                        $_SESSION['val_error'] = "Nie poprawny e-mail";
                    }
                }
                else{
                    $_SESSION['val_error'] = "Nazwisko może zawierać tylko litery. Od 2 do 30 znaków.";
                }
            }
            else{
                $_SESSION['val_error'] = "Imie może zawierać tylko litery. Od 2 do 30 znaków.";
            }
			// $_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
        }
        else{
            $_SESSION['val_error'] = "Potwierdź, że nie jesteś botem.";
        }

        $connection->close();
        header('Location: register-form.php');
?>
