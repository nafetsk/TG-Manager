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

<div class="doppel_formular">
    <div class="formulare">
        <h1>Nachtrag</h1>
        <form action="nachtrag_formular_php.php" method="post" >
        <div> <h2>Wann</h2>

                <input type="text" name="datum" >

        </div>
        <div>
            <h2 >Wie viel?</h2>
            <input type="text" name="betrag" >
        </div>

        <div>
            <h2>Wofuer?</h2>
            <input type="text" name="zweck" >
        </div>
        <div> <h2 >Welche Kategorie?</h2>

            <input type="text" name="kategorie">

        </div>
            <div class="button-container_2">
                <button class="button" type="submit">Nachtragen!</button>
            </div>
        </form>

    </div>
<div class="formulare">
    <h1>Nachtrag Löschen</h1>
    <form action="nachtrag_formular_php.php" method="post" >
        <div>

            <h2>Von Wann war der Nachtrag?</h2>

            <input type="text" name="datum_loeschen" >

        </div>
        <div>
            <h2 >Wie hoch war der Nachtrag?</h2>
            <input type="text" name="betrag_loeschen" >
        </div>

        <div class="button-container_2">
            <button class="button" type="submit">Nachtrag Löschen!</button>
        </div>
    </form>
</div>

</div>
</div>
<?php

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}

$datum = $_POST['datum'];
$betrag = $_POST['betrag'];
$zweck = $_POST['zweck'];
$kategorie = $_POST['kategorie'];

date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum_automatisch = date("Y.m.d",$timestamp);

$datum1 = new DateTime($_POST['datum']);

if ($datum == "heute"){
    $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss', $datum_automatisch, $betrag, $zweck, $kategorie);
    $insertSuccessful = $stmt->execute();
}
else {

    $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ssss', $datum1->format('Y-m-d'), $betrag, $zweck, $kategorie);
    $insertSuccessful = $stmt->execute();
}
if (isset($_POST['betrag'])){
    header('Location: index.php');
    exit;
}
$datum_loeschen = $_POST['datum_loeschen'];
$betrag_loeschen = $_POST['betrag_loeschen'];
$sql = "DELETE FROM Transaktionen WHERE datum =? AND betrag =? ";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss",$datum_loeschen, $betrag_loeschen);
$stmt->execute();
$stmt->close();
if (isset($_POST['datum_loeschen'])) {
    header('Location: index.php');
    exit;
}
?>
</body>
</html>