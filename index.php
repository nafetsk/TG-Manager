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
    <div>
        <h1>Kontostand am
            <?php
            date_default_timezone_set("am");
            $timestamp = time();
            $datum = date("d.m.Y",$timestamp);
            echo "$datum";
            ?>
        </h1>
    <?php
    $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
    if ($mysqli->connect_error) {
        echo "Fehler bei Verbindung:" . mysqli_connect_error();
        exit();
    }
    $ergebnis = $mysqli->query("SELECT SUM(betrag) as summe FROM Transaktionen;");
    while ($zeile = $ergebnis->fetch_array()) {
        echo "<h1>{$zeile['summe']} €</h1>";
    }
    ?>
    </div>
    <div class="spalten_index">
        <?php
        $ergebnis = $mysqli->query("SELECT kategorie, SUM(betrag) AS summe FROM Transaktionen GROUP BY kategorie ORDER BY kategorie;");
        while ($zeile = $ergebnis->fetch_array()) {
            echo "<h2>{$zeile['kategorie']} <strong><br> {$zeile['summe']}€ </strong> </h2>";

        }
        ?>
    </div>
    <div class="datensätze">
        <h2>Letzte Umbuchungen</h2>
        <?php
        $ergebnis = $mysqli->query("Select datum, betrag, zweck, kategorie FROM Transaktionen ORDER BY datum DESC LIMIT 8;");
        while ($zeile = $ergebnis->fetch_array()) {
            $datum = new DateTime($zeile['datum']);
            echo "<strong>{$zeile['betrag']} €</strong>: {$zeile['zweck']} {$datum->format('d.m.Y')} {$zeile['kategorie']} <br>";
        }
        ?>

    </div>
    <div class="link_alle_datensätze_container">
    <a class ="link_alle_datensätze" href="alle_datensätze.php">Alle Umbuchungen</a>
    </div>
    <div class="button-container">
        <a class="button" href="nachtrag_formular_php.php">Nachtrag</a>
        <!--
        <a class="button" href="spalten_bearbeiten.php">Spalten bearbeiten</a>
        -->
    </div>
    </div>


    </div>

</div>


</body>
</html>
