<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    include ('head.php');
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
    <h1>Einstellungen</h1>
    <br>
    <div class="einnahmen">
    <span>
        Hier kannst du deine deine automatischen Umbuchungen eintragen.
        Sie werden je nachdem, welchen Intervall du gewählt hast jeden Montag oder immer zum ersten des neuen Monats auf dein Konto gebucht.
        Dies geht allerdings nur, wenn du vorher schon Nachträge mit Kategorien erstellt hast
    </span>
    </div>
    <div class="spalten">
        <form action="Einstellungen.php" method="post">
            <?php
session_start();
$benutzer = $_SESSION["benutzer_id"];
$intervall = $_POST['intervall'];
$beginn = new DateTime();

            $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
            if ($mysqli->connect_error) {
                echo "Fehler bei Verbindung:" . mysqli_connect_error();
                exit();
            }
            $ergebnis = $mysqli->query("SELECT kategorie FROM Transaktionen WHERE Benutzer = \"$benutzer\";");
            $zeile = $ergebnis->fetch_array();
            if (!empty($zeile['kategorie'])) {

            $ergebnis = $mysqli->query("SELECT kategorie FROM Abo WHERE benutzer = \"$benutzer\";");
            $zeile = $ergebnis->fetch_array();

            if (empty($zeile['kategorie'])) {

            $ergebnis = $mysqli->query("SELECT kategorie FROM Transaktionen WHERE Benutzer = \"$benutzer\" GROUP BY kategorie ORDER BY kategorie;");
            while ($zeile = $ergebnis->fetch_array()) {
                echo "<strong>{$zeile['kategorie']} </strong><br> <input type='text' name='{$zeile['kategorie']}'>€ <br> ";
            }
            ?>
            <input type="radio" value="wöchentlich" name="intervall">Wöchentlich
            <input type="radio" value="monatlich" name="intervall">Monatlich
            <div class="button-container_2">
                <button class="button" type="submit">Einstellen</button>
            </div>

        </form>
        <?php

        if (!empty($_POST)) {
            foreach ($_POST as $kategorieName => $betrag) {
                if ($kategorieName !== "intervall" && $kategorieName !== "beginn") {
                    $sql = "INSERT INTO Abo (kategorie, betrag, intervall, benutzer, datum) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param('sssss', $kategorieName, $betrag, $intervall, $benutzer, $beginn->format('Y-m-d'));
                    $insertSuccessful = $stmt->execute();
                }
            }
            header("Location: index.php");
        }

        }
        else {
        ?>
        <div class="button-container">
            <a class="button" href="einstellungen_loeschen.php">Einstellungen zurücksetzen</a>
        </div>
        <div class="aktuelle_abos">
            <span>Aktuell eingestellte Einnahmen</span>
            <br>
            <?php

            $ergebnis = $mysqli->query("SELECT kategorie, betrag, intervall FROM Abo WHERE benutzer = \"$benutzer\";");
            while ($zeile = $ergebnis->fetch_array()) {
                echo "<strong>{$zeile['kategorie']}</strong> &nbsp; {$zeile['betrag']}€<br>";
                $intervall_eingestellt = $zeile['intervall'];
            }

            }
            echo "<strong>$intervall_eingestellt</strong>";
            }
        ?>
            </div>
    </div>
</div>

<div class="impressum">
    <a href="impressum.php">Impressum</a>
</div>
</body>
</html>