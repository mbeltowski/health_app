<?php
require_once "session_mgr/session_mgr.php";
if( isset($_SESSION['logedin']) || $_SESSION['logedin'] == true ){
    header('Location: user/user_panel/user_panel.php');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main_css/style.css">
    <title>Health App - Main Page!</title>

    <script src="https://kit.fontawesome.com/9480ce7d31.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="web">
        <nav class="main_page_nav">
            <img src="img/logo.svg" alt="logo" class="main_page_nav_logo">
            <div class="main_page_nav_btn_box">
                <a href="login/login-form.php" class="main_page_nav_btn">zaloguj</a>
                <a href="register/register-form.php" class="main_page_nav_btn">zarejestruj</a>
            </div>
        </nav>
        <main>
            <section class="main_page_section">
                <div class="section-hook1"  id="sec1"></div>
                <div class="main_page_section_content_box">
                    <h1>Stwórz własny plan żywnieniowy w funkcji "Diety".</h1>
                    <h2>Dodaj swoje posiłki oraz pory w których chcesz je zjeść. Nie ograniczaj się do dodania planu na jeden tydzień, możesz dodać tyle diet ile chcesz.</h2>
                    <a href="#sec2" class="main_page_section_next_button">
                        <i class="fas fa-angle-double-down"></i>
                    </a>
                </div>
                <i class="far fa-calendar-alt main_page_section_icon_box"></i>

            </section>
            <section class="main_page_section" >
            <div class="section-hook" id="sec2"></div>
                <div class="main_page_section_content_box">
                    <h1>Aktywności - zarządzaj lepiej swoim czasem.</h1>
                    <h2> Zaplanuj swoje treningi, czytanie książki, naukę, odpoczynek lub jakąś inną czynność.</h2>
                    <a href="#sec3" class="main_page_section_next_button">
                        <i class="fas fa-angle-double-down"></i>
                    </a>
                </div>
                <i class="fas fa-chart-line main_page_section_icon_box"></i>

            </section>
            <section class="main_page_section">
            <div class="section-hook" id="sec3"></div>
                <div class="main_page_section_content_box">
                    <h1>Notatki - zapisz sobie to co potrzebujesz zeby tego nie zapomnieć.</h1>
                    <h2>Wykorzystaj funkcję "notatek" do zapisywania rzeczy ważnych i tych mniej ważnych. Dzięku temu że naszą aplikację możesz obsługiwać również na telefonie będizesz miał zawsze łatwy dostęp do swoich notatek.</h2>
                    <a href="#sec4" class="main_page_section_next_button">
                        <i class="fas fa-angle-double-down"></i>
                    </a>
                </div>
                <i class="fas fa-clipboard main_page_section_icon_box"></i>

            </section>
            <section class="main_page_section">
            <div class="section-hook" id="sec4"></div>
                <div class="main_page_section_content_box">
                    <h1>Daily Hinty - motywacja, dobra rada, ciekawostka każdego dnia.</h1>
                    <h2>Daily Hinty to krótkie sentencje które pojawiają się po zalogowaniu. Co dziennie posiadają inną zawartość.</h2>
                    <a href="#sec1" class="main_page_section_next_button">
                        <i class="fas fa-angle-double-up"></i>
                    </a>
                </div>
                <div class="main_page_section_icon_box"> 
                    <i class="fas fa-quote-left quote_icon"></i>
                    <i class="fas fa-quote-right quote_icon"></i>
                </div>

            </section>
        </main>
        <footer>
            <p>stworzone przez Janaszek & Bełtowski, wszystkie prawa zastrzeżone &copy;</p>
        </footer>
    </div>

    <script>

    </script>
</body>
</html>