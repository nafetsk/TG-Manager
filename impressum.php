<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    include ('head.php');
    ?>
</head>
<body>
<div class="navbar">
    <div class="navbar__element">
        <span class="tg_manager">TG Manager</span>
    </div>
    <div class="navbar__element">
        <nav class="nav-main">
            <ul class="nav-main__list">
                <li class="nav-main__items">
                    <a class="button" href="Einstellungen.php">Einstellungen</a>
                </li>
                <li class="nav-main__items">
                    <a class="button" href="index.php">Übersicht</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php
    if ($_SESSION['benutzer']) {
        ?>
        <div class="navbar__element_2">
            <a class="button" href="abmelden.php">Abmelden</a>
            &nbsp;
            <a class="account" href="index.php">
                <?php
                echo "{$_SESSION['benutzer']}"
                ?> </a>
        </div>
        <?php
    }
    else {
        ?>
        <div class="navbar__element_2">
            <a class="button" href="anmelden.php">Anmelden</a>
        </div>
        <?php
    }
    ?>
</div>

<div class="hauptseite">
    <h1>Impressum</h1>
<div class="impressum_text">
    <span>
        <strong>Stefan Klotz</strong>
        <br>
<br>
        <strong>Kontakt</strong>

        <br>
E-Mail: kl.stefan@gmx.de
        <br>
GitHub: nafetsk
        <br>
<br>
        <strong>Info</strong>
        <br>
Die Website ist während eines dreiwöchigen Schülerpraktikum bei der Webfactory GmbH entstanden.
        <br>
Vielen Dank für die ganze Unterstützung!!!</span>
</div>
</div>

<div class="impressum">
    <a href="impressum.php">Impressum</a>
</div>
</body>
</html>