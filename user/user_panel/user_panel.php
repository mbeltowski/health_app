<?php
    session_start();
    require_once "../../session_mgr/session_mgr.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    require_once "daily_hint.php";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
</head>
<body>
 
    <div class="container">
<?php 
echo $daily_hint_html;
require_once "../user_panel_navigation.php";
?>

        <main>
            <h2>WITAJ W PANELU UŻYTKOWNIKA <?php $_SESSION['user_name'] ?></h2>
        </main>
    </div>

    <script src="hide_hint.js"></script>
</body>
</html>