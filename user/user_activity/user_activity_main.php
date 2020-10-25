<?php 
    
    require_once "../../session_mgr/session_mgr.php";
    require_once "../../connection_php/connection.php";

    if( !isset($_SESSION['logedin']) || $_SESSION['logedin'] == false ){
        header('Location: ../../index.php');
    }

    $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą danych.");

    
    $today_date = date("Y-m-d");
    $today_day_name = date("D");

    $day = date('w');
    if($day == 0){
        $day = 7;
    }
    $day_of_week = array("poniedzialek", "wtorek", "środa", "czwartek", "piątek", "sobota", "niedziela");

    $data_poniedzialek = date( 'Y-m-d', strtotime( $today_date .' - '.($day-1).' day' ));
    $data_niedziela = date( 'Y-m-d', strtotime( $today_date .' + '.(7-$day).' day' ));

    $user_id = $_SESSION['loged_user_id'];

    $has_user_ever_had_activities_SQL = "SELECT * FROM user_activities WHERE user_id = '$user_id' LIMIT 1";
    $has_user_ever_had_activities_RESULT =  $connection->query($has_user_ever_had_activities_SQL);
    $has_user_ever_had_activities_ROWS = $has_user_ever_had_activities_RESULT->num_rows;

    if( !$has_user_ever_had_activities_ROWS > 0){
        //nowy user trzeba mu pokazać podpowiedz
    }

    $get_activities_SQL = "SELECT * FROM user_activities WHERE user_id = '$user_id' AND activity_date BETWEEN '$data_poniedziałek' AND '$data_niedziela' GROUP BY activity_date";
    $get_activities_RESULT = $connection->query($get_activities_SQL);
    $get_activities_ROWS = $get_activities_RESULT->num_rows;

    $html = '';
    $html_dni = '';
    if($get_activities_ROWS > 0){
        //user ma aktywnośći
        mysqli_free_result($get_activities_RESULT);

        for($i = 0; $i<7; $i++){

            $data_dzisiejsza = date( 'Y-m-d', strtotime( $data_poniedzialek .' + '.$i.' day' ));

            $html_dni .= '
            <td>
                <p>'. $day_of_week[$i] .'</p>
                <p>'.$data_dzisiejsza.'</p>
            </td>
            ';


            $czy_dzisiaj_ma_aktywnosci = false;
            $get_activities_RESULT = $connection->query($get_activities_SQL);
            while($row = mysqli_fetch_assoc($get_activities_RESULT)){
                if($row['activity_date'] == $data_dzisiejsza){
                    $czy_dzisiaj_ma_aktywnosci = true;
                }
            }
            mysqli_free_result($get_activities_RESULT);
            if($czy_dzisiaj_ma_aktywnosci){
                //są aktywności
                //!trzeba potem zmienić adresy
                $html .='
                    <td>
                        <img src="user_activity_img/img2.png" alt="dodało_zdjecie">
                        <a href="user_activity_add.php?data='.$data_dzisiejsza.'" class="activity_table_btn">podgląd / dodaj</a>
                    </td>
                ';
            }
            else{
                //nie ma aktywnosci
                //!trzeba potem zmienić adresy
                $html .='
                <td>
                    <img src="user_activity_img/img1.png" alt="dodało_zdjecie">
                    <a href="user_activity_add.php?data='.$data_dzisiejsza.'" class="activity_table_btn">dodaj</a>
                </td>
                ';
            }
        }
    }
    else{
        //user nie ma aktywnosci w tym 
        //można wszystko dać "[+]"

        for($i = 0; $i<7; $i++){

            $data_dzisiejsza = date( 'Y-m-d', strtotime( $data_poniedzialek .' + '.$i.' day' ));
            //nie ma aktywnosci
            //!trzeba potem zmienić adresy
            $html .='
            <td>
                <img src="user_activity_img/img1.png" alt="dodało_zdjecie">
                <a href="user_activity_add.php?data='.$data_dzisiejsza.'" class="activity_table_btn">dodaj</a>
            </td>
            ';
        }
    }


?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../user_panel_css/user_panel_css.css">
    <link rel="stylesheet" href="user_activity.css">
</head>
<body>
    
<?php 
require_once "../user_panel_navigation.php";
?>

    <table class="activity_table">
            <tr>
                <?php
                    echo $html_dni;
                ?>
            </tr>
            <tr>
                <?php
                    echo $html;
                ?>
            </tr>      
    </table>

</body>
</html>