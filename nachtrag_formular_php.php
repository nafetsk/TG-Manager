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
        <span class="name">Stefan Klotz</span>
    </div>
</div>

<div class="hauptseite">
    <h1>Nachtrag</h1>

    <div class="Spalten">
        <form action="nachtrag_formular_php.php" method="post" accept-charset="utf-8">
        <div> <h2 class="Klamotten">Wann</h2>

                <input type="text" name="datum" >

        </div>
        <div>
            <h2 class="Taschengeld">Wie viel?</h2>
            <input type="text" name="preis" >
        </div>

        <div>
            <h2 class="Frisör">Wofuer?</h2>
            <input type="text" name="grund" >
        </div>
        <div> <h2 class ="Spargeld">In welche Spalte?</h2>

            <input type="radio" name="spalte" value="klamotten"><span>Klamotten</span>
            <input type="radio" name="spalte" value="frisoer"><span>Frisoer</span>
            <input type="radio" name="spalte" value="taschengeld"><span>Taschengeld</span>
            <input type="radio" name="spalte" value="spargeld"><span>Spargeld</span>

        </div>
            <input class="abschicken" type="submit" value="Abschicken">
        </form>

    </div>
</div>





<?php

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}

$datum = $_POST['datum'];
$preis = $_POST['preis'];
$grund = $_POST['grund'];


if ($_POST['spalte'] === "klamotten"){
    $sql = "INSERT INTO Klamotten (datum, preis, grund) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $datum, $preis, $grund);
    $insertSuccessful = $stmt->execute();
}

else if ($_POST['spalte'] === "frisoer"){
    $sql = "INSERT INTO Frisoer (datum, preis, grund) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $datum, $preis, $grund);
    $insertSuccessful = $stmt->execute();
}
else if ($_POST['spalte'] === "taschengeld"){
    $sql = "INSERT INTO Taschengeld (datum, preis, grund) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $datum, $preis, $grund);
    $insertSuccessful = $stmt->execute();
}
else if ($_POST['spalte'] === "spargeld"){
    $sql = "INSERT INTO Spargeld (datum, preis, grund) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sss', $datum, $preis, $grund);
    $insertSuccessful = $stmt->execute();
}

if(isset($_POST['preis'])){
    header('Location: index.php');
    exit;
}

?>
</body>
</html>