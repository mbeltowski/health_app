<?php
require_once "../../session_mgr/session_mgr.php";
require_once "../../connection_php/connection.php";

if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
    header('Location: ../../index.php');
}

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą");
$user_id = $_SESSION['loged_user_id'];

$notes_html = '';
$nie_masz_html = '';
if($connection){
    mysqli_query($connection, "SET character_set_results=utf8");

   $expiration_clear_SQL = "DELETE FROM notes WHERE note_expiration_date < now() AND note_expiration_date != '0000-00-00'" ;
   $expiration_clear_RESULT = $connection->query($expiration_clear_SQL);

    $get_notes_SQL = "SELECT * FROM notes WHERE user_id = '$user_id'";
    $get_notes_RESULT = $connection->query($get_notes_SQL);

    $get_notes_ROWS = $get_notes_RESULT->num_rows;
    if($get_notes_ROWS > 0){

        while ($notatka = mysqli_fetch_assoc($get_notes_RESULT)) {
            $note_title = $notatka['note_title'];
            $note_create_date = $notatka['note_create_date'];
            $note_exp_date = $notatka['note_expiration_date'];
            $note_content = $notatka['note_content'];

            if($notatka['note_expiration_date'] != 0){
                $notes_html .= '
                <div class="note_box">
                <div class="note_top_container">
                    <h2 class="note_title">'. $note_title .'</h2>
                    <h3 class="note_create_date">'. $note_create_date .'</h3>
                    <h3 class="note_exp_date">'. $note_exp_date .'</h3>
                    </div>
                    <p class="note_content">'. $note_content .'</p>
                </div>
                ';
            }
            else{
                $notes_html .= '
                <div class="note_box">
                <div class="note_top_container">
                    <h2 class="note_title">'. $note_title .'</h2>
                    <h3 class="note_create_date">'. $note_create_date .'</h3>
                    </div>
                    <p class="note_content">'. $note_content .'</p>
                </div>
                ';
            }
        }

    }
    else{
        $no_notes_html =  '<p class="empty_notes">Nie masz żadnych notatek!</p>';
    }   
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notatki</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="notes.css">
</head>
<body>

<?php 
require_once "../user_panel_navigation.php";
?>

    <form action="add_note.php" method="post" class="add_note_form">
        <label for="note_title" class="add_note_label">Tytuł notatki</label>
        <input type="text" name="note_title" class="add_note_title" required>

        <label for="note_content" class="add_note_label">Treść notatki</label>
        <textarea type="text" name="note_content" class="add_note_content" required></textarea>
        
        <label for="note_expire_date" class="add_note_label">Data wygaśnięcia notatki (opcjonalne) </label>
        <input type="date" name="note_expire_date" class="add_note_expire_date">

        <input type="submit" value="Dodaj" class="add_note_submit">
        </form> 

    <div class="notes_container">
    <?php 
        echo $notes_html;
        if($no_notes_html != ''){
            echo $no_notes_html;
        }

        if( isset($_SESSION['add_note_confirm']) ){
            echo '
                <div class="add_note_confirm">
                    <p add_note_confirm_content>'. $_SESSION['add_note_confirm'] .'</p>
                    <button class="add_note_confirm_btn"> ok! </button>
                </div>
            ';
            unset($_SESSION['add_note_confirm']);
        }
    ?>
    </div>

    <script src="remove_add_note_confirm.js"></script>
</body>
</html>