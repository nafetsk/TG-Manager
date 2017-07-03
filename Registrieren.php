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
    <h1>Registrierung</h1>
    <div class ="spalten">
    <form action="Registrieren.php" method="post">
        <h2>Vorname</h2>
        <input type="text" name="Vorname">
        <h2>Nachname</h2>
        <input type="text" name="Name">
        <h2>E-Mail</h2>
        <input type="text" name="e_mail">
        <div class="button-container_3">
            <button class="button" type="submit">Registrieren</button>
        </div>
    </form>
    </div>
</div>
<?php

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}
$Vorname = $_POST['Vorname'];
$Name = $_POST['Name'];
$e_mail = $_POST['e_mail'];

$sql = "INSERT INTO Benutzer (Vorname, Name, e_mail) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('sss', $Vorname, $Name, $e_mail);
$insertSuccessful = $stmt->execute();

if(isset($_POST['Vorname'])){
    header('Location: index.php');
    exit;
}
?>

</body>
</html>