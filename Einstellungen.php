<!DOCTYPE html>
<html>
<head>
    <title>TG Manager</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
</head>
<body>
<div class="navbar">
    <div class="navbar__element">
        <img class="logo" src="images/Logo2.png">
        <span class="tg_manager">TG Manager</span>
    </div>
    <div class="navbar__element">
        <nav class="nav-main">
            <ul class="nav-main__list">
                <li class="nav-main__items">
                    <a class="nav-main__text" href="Einstellungen.php">Einstellungen</a>
                </li>
                <li class="nav-main__items">
                    <a class="nav-main__text" href="index.php">Uebersicht</a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="navbar__element">
        <a class="registrieren" href="Registrieren.php">Registrieren</a>
    </div>
</div>

<div class="hauptseite">
    <h1>Einstellungen</h1>
    <br>
    <h2 id="einnahmen">Einnahmen im Monat</h2>

    <div class="spalten">
        <form action="Einstellungen.php" method="post">
            <?php

            $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
            if ($mysqli->connect_error) {
                echo "Fehler bei Verbindung:" . mysqli_connect_error();
                exit();
            }

            $ergebnis = $mysqli->query("SELECT kategorie FROM Transaktionen GROUP BY kategorie ORDER BY kategorie;");
            while ($zeile = $ergebnis->fetch_array()) {
                echo "{$zeile['kategorie']} <br> <input type='text' name='{$zeile['kategorie']}'> <br> ";
            }
            ?>
            <div class="button-container_2">
                <button class="button" type="submit">Einstellen</button>
            </div>
        </form>

    </div>

</div>
<?php

?>

</body>
</html>