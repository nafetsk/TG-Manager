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
    <h1>Kontostand:</h1>

    <div class="spalten_index">
        <h2 class="Klamotten">Klamotten</h2> <h2 class="Taschengeld">Taschengeld</h2>
        <h2 class="Frisör">Frisoer</h2> <h2 class ="Spargeld">Spargeld</h2>
    </div>
    <div class="datensätze">
    <div class="klamotten_datenbank">
<?php
//Verbindung zur Datenbank
$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}
//Abrufen der Datensätze
$ergebnis = $mysqli->query("Select datum, preis, grund FROM Klamotten;");
while ($zeile = $ergebnis->fetch_array()) {
    echo "<strong>{$zeile['preis']}</strong>: {$zeile['grund']} {$zeile['datum']}
	<br>";
}
?>
</div>

    <div class="taschengeld_datenbank">
        <?php
        //Abrufen der Datensätze
        $ergebnis = $mysqli->query("Select datum, preis, grund FROM Taschengeld;");
        while ($zeile = $ergebnis->fetch_array()) {
            echo "<strong>{$zeile['preis']}</strong>: {$zeile['grund']} {$zeile['Datum']}
	<br>";
        }
        ?>
    </div>

    <div class="frisoer_datebank_datenbank">
        <?php
        //Abrufen der Datensätze
        $ergebnis = $mysqli->query("Select datum, preis, grund FROM Frisoer;");
        while ($zeile = $ergebnis->fetch_array()) {
            echo "<strong>{$zeile['preis']}</strong>: {$zeile['grund']} {$zeile['datum']}
	<br>";
        }
        ?>
    </div>

    <div class="spargeld_datenbank">
        <?php
        //Abrufen der Datensätze
        $ergebnis = $mysqli->query("Select datum, preis, grund FROM Spargeld;");
        while ($zeile = $ergebnis->fetch_array()) {
            echo "<strong>{$zeile['preis']}</strong>: {$zeile['grund']} {$zeile['datum']}
	<br>";
        }
        ?>
    </div>
    </div>

    <div class="button-container">
        <a class="button" href="nachtrag_formular_php.php">Nachtrag</a>
    </div>
    </div>

</div>


</body>
</html>
