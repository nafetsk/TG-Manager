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
    <div class="spalten">
    <form action="spalten_bearbeiten.php" method="post">
        <h1>Spalte hinzufügen</h1>
        <h2>Name</h2>
        <input type="text" name="name_spalte">
        <br>
        <input type="submit" value="Hinzufügen">
    </form>
        <form action="spalten_bearbeiten.php" method="post">
        <h1>Spalte entfernen</h1>
        <h2>Name</h2>
        <input type="text" name="spalte_loeschen">
            <br>
            <input type="submit" value="Entfernen">
    </form>
    </div>
</div>
<?php
$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}
$name_spalte = $_POST['name_spalte'];
$sql = "INSERT INTO Kategorie (kategorie) VALUES (?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s',$name_spalte);
$insertSuccessful = $stmt->execute();
if (isset($_POST['name_spalte'])){
    header('Location: index.php');
    exit;
}

$spalte_loeschen = $_POST['spalte_loeschen'];
$sql = "DELETE FROM Kategorie WHERE kategorie =?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $spalte_loeschen);
$stmt->execute();
$stmt->close();
if (isset($_POST['spalte_loeschen'])) {
    header('Location: index.php');
    exit;
}
?>

</body>
</html>