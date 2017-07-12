<html>
<?php
session_start();
$benutzer = $_SESSION["benutzer_id"];

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}

$sql = "DELETE FROM Transaktionen WHERE Benutzer = \"$benutzer\" ORDER BY id DESC LIMIT 1 ";
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$stmt->close();
header('Location: index.php');
exit;
?>
</html>