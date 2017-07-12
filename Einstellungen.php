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
                    <a class="nav-main__text" href="index.php">Übersicht</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php
    session_start();
    ?>
    <div class="navbar__element">
        <a class="registrieren" href="abmelden.php">Abmelden</a>
        &nbsp;
        <a class="registrieren" href="index.php">
            <?php
            echo "{$_SESSION['benutzer']}"
            ?>
        </a>
    </div>
</div>

<div class="hauptseite">
    <h1>Einstellungen</h1>
    <br>
    <h2 id="einnahmen">Einnahmen</h2>

    <div class="spalten">
        <form action="Einstellungen.php" method="post">
            <?php
session_start();
$benutzer = $_SESSION["benutzer_id"];
$intervall = $_POST['intervall'];
$beginn = new DateTime($_POST['beginn']);

            $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
            if ($mysqli->connect_error) {
                echo "Fehler bei Verbindung:" . mysqli_connect_error();
                exit();
            }

            $ergebnis = $mysqli->query("SELECT kategorie FROM Abo WHERE benutzer = \"$benutzer\";");
            $zeile = $ergebnis->fetch_array();

            if (empty($zeile['kategorie'])) {

            $ergebnis = $mysqli->query("SELECT kategorie FROM Transaktionen WHERE Benutzer = \"$benutzer\" GROUP BY kategorie ORDER BY kategorie;");
            while ($zeile = $ergebnis->fetch_array()) {
                echo "{$zeile['kategorie']} <br> <input type='text' name='{$zeile['kategorie']}'> <br> ";
            }
            ?>
            <input type="radio" value="wöchentlich" name="intervall">Wöchentlich
            <input type="radio" value="monatlich" name="intervall">Monatlich
            <br>
            <br>
            <span>Wann soll der Intervall starten?</span>
            <br>
            <input type="text" name="beginn">
            <div class="button-container_2">
                <button class="button" type="submit">Einstellen</button>
            </div>

        </form>
        <?php

        if (!empty($_POST)){
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
            <a class="button" href="einstellungen_loeschen.php">Einstellungen reseten</a>
        </div>
            <div class="aktuelle_abos">
                <span>Aktuell eingestellte Einnahmen</span>
                <br>
            <?php

            $ergebnis = $mysqli->query("SELECT kategorie, betrag, intervall FROM Abo WHERE benutzer = \"$benutzer\";");
            while ($zeile = $ergebnis->fetch_array()) {
                echo "<strong>{$zeile['kategorie']}</strong> &nbsp; {$zeile['betrag']}€<br>";
            }

        }
        ?>
            </div>
    </div>
</div>


</body>
</html>