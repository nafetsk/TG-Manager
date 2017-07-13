<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <?php
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

        </nav>
    </div>

    <div class="navbar__element">
        <a class="button_wilkommen" href="anmelden.php">Anmelden</a>
        <a class="button_wilkommen" href="Registrieren.php">Registrieren</a>
    </div>
</div>

<div class="hauptseite">
    <h1>Anmelden</h1>
    <div class ="spalten">
        <form action="anmelden.php" method="post">
            <h2>E-Mail</h2>
            <input type="text" name="e_mail" >
            <h2>Passwort</h2>
            <input type="password" name="passwort" >
            <div class="button-container_3">
                <button class="button" type="submit">Anmelden</button>
            </div>
        </form>

</div>
<?php

include("dbinit.php");

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}
$e_mail = $_POST['e_mail'];
$passwort = $_POST['passwort'];

$statement = $mysqli->prepare("Select id, Vorname, random_id FROM Benutzer Where e_mail = ? and passwort = ?");
$statement->bind_param("ss", $e_mail, $passwort);
$statement->execute();
$statement->bind_result($id, $vorname, $random_id_alt);
$statement->fetch();
$statement->close();

if ($id) {
    $_SESSION["benutzer"] = $vorname;
    $_SESSION["benutzer_id"] = $id;
        header('Location: index.php');
}

else if ($_POST['e_mail'] && !$id) {
    echo "<h1>Falsche E-Mail Adresse oder Passwort</h1>";
}
else{
    echo "<h1>Melde dich an!</h1>";
}
?>
</div>
<div class="impressum">
    <a href="impressum.php">Impressum</a>
</div>
</body>
</html>