<!DOCTYPE html>
<html>
<head>
    <?php
    include ('head.php');
    session_start();
    if (!$_SESSION['benutzer']){
        header('Location: index.php');
    }
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
    <div class="navbar__element_2">
        <a class="button" href="abmelden.php">Abmelden</a>
        &nbsp;
        <a class="account" href="index.php">
            <?php
            echo "{$_SESSION['benutzer']}"
            ?> </a>
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
$datum_echt = $_POST['datum'];
$betrag = $_POST['betrag'];
$zweck = $_POST['zweck'];
$kategorie = $_POST['kategorie'];
$benutzer = $_SESSION["benutzer_id"];

date_default_timezone_set("Europe/Berlin");
$timestamp = time();
$datum_automatisch = date("Y-m-d",$timestamp);

if ($_POST['datum'] !== "heute"){
    $datum = new DateTime($_POST['datum']);
}

if ($datum_echt === "heute"){
    $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie, benutzer) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssss', $datum_automatisch, $betrag, $zweck, $kategorie, $benutzer);
    $insertSuccessful = $stmt->execute();
}
else {

    $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie, benutzer) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('sssss', $datum->format('Y-m-d'), $betrag, $zweck, $kategorie, $benutzer);
    $insertSuccessful = $stmt->execute();
}
if (isset($_POST['betrag'])){
    header('Location: index.php');
    exit;
}
$betrag_loeschen = $_POST['betrag_loeschen'];
$datum2 = new DateTime($_POST['datum_loeschen']);
$sql = "DELETE FROM Transaktionen WHERE datum =? AND betrag =? AND Benutzer = \"$benutzer\" ";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss",$datum2->format('Y-m-d'), $betrag_loeschen);
$stmt->execute();
$stmt->close();
if (isset($_POST['datum_loeschen'])) {
    header('Location: index.php');
    exit;
}
echo " {$_SESSION['benutezr']}";

?>
<div class="impressum">
    <a href="impressum.php">Impressum</a>
</div>
</body>
</html>