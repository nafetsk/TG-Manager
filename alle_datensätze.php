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
    <h1>Alle Umbuchungen</h1>
    <?php

    $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
    if ($mysqli->connect_error) {
        echo "Fehler bei Verbindung:" . mysqli_connect_error();
        exit();
    }
?>
    <div class="datensätze">
    <?php
    $ergebnis = $mysqli->query("Select datum, betrag, zweck, kategorie FROM Transaktionen ORDER BY datum DESC;");
    while ($zeile = $ergebnis->fetch_array()) {
        $datum = new DateTime($zeile['datum']);
        echo "<strong>{$zeile['betrag']} €</strong>: {$zeile['zweck']} {$datum->format('d.m.Y')} {$zeile['kategorie']} <br>";
    }
    ?>
    </div>
</div>


</body>
</html>