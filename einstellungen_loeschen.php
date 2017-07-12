<html>
<?php
session_start();
$benutzer = $_SESSION["benutzer_id"];

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}

$sql = "DELETE FROM Abo WHERE Benutzer = \"$benutzer\"";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->close();
header('Location: Einstellungen.php');
exit;
?>
</html>