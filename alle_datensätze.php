<!DOCTYPE html>
<html>
<head>
    <title>TG Manager</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <?php
    #ini_set('display_errors', true);
    include ('abo.php');
    ?>
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
    $benutzer = $_SESSION["benutzer_id"];
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
    <h1>Alle Umbuchungen</h1>
    <?php
    $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
    if ($mysqli->connect_error) {
        echo "Fehler bei Verbindung:" . mysqli_connect_error();
        exit();
    }

    if (!isset($_GET['seite']) || !is_numeric($_GET['seite'])) {
        $_GET['seite'] = 1;
    }
//    $temp = $mysqli->query("SELECT COUNT(*) as anzahl FROM Transaktion");
//    $z = $temp->fetch_array();
//    $anzahl = $z["anzahl"];

    $eintraege_pro_seite = 27 ;

    $start = $_GET['seite'] * $eintraege_pro_seite - $eintraege_pro_seite;


?>
    <div class="datensätze">
    <?php
    $ergebnis = $mysqli->query("Select datum, betrag, zweck, kategorie FROM Transaktionen WHERE Benutzer = \"$benutzer\" ORDER BY datum DESC LIMIT $start, $eintraege_pro_seite;");
    while ($zeile = $ergebnis->fetch_array()) {
        $datum = new DateTime($zeile['datum']);
        echo "<strong>{$zeile['betrag']} €</strong>: {$zeile['zweck']} {$datum->format('d.m.Y')} {$zeile['kategorie']} <br>";
    }
    ?>
    </div>
    <div class="blaettern">
        <a href="alle_datensätze.php?seite=1">1</a>
        <a href="alle_datensätze.php?seite=2">2</a>
        <a href="alle_datensätze.php?seite=3">3</a>
        <a href="alle_datensätze.php?seite=4">4</a>
        <a href="alle_datensätze.php?seite=5">5</a>
        <a href="alle_datensätze.php?seite=6">6</a>
        <a href="alle_datensätze.php?seite=7">7</a>
        <a href="alle_datensätze.php?seite=8">8</a>
        <a href="alle_datensätze.php?seite=9">9</a>
        <a href="alle_datensätze.php?seite=10">10</a>
    </div>
</div>


</body>
</html>