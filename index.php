<!DOCTYPE html>
<html>
<head>
    <?php
    session_start();
    include ('head.php');
    include ('abo.php');
    $benutzer = $_SESSION["benutzer_id"];
    ?>
</head>
<body>
<?php
if ($_SESSION['benutzer']) {
?>
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
    <div>
        <h1>Kontostand am
            <?php
            $timestamp = time();
            $datum = date("d.m.Y", $timestamp);
            echo "$datum";
            ?>
        </h1>
        <?php


        $mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
        if ($mysqli->connect_error) {
            echo "Fehler bei Verbindung:" . mysqli_connect_error();
            exit();
        }
        $ergebnis = $mysqli->query("SELECT SUM(betrag) as summe FROM Transaktionen WHERE Benutzer = \"$benutzer\";");
        while ($zeile = $ergebnis->fetch_array()) {
            if ($zeile['summe']) {
                echo "<h1>{$zeile['summe']} €</h1>";
            } else {
                echo "<h1>0€</h1>";
            }
        }
        ?>
    </div>
    <div class="spalten_index">
        <?php
        $ergebnis = $mysqli->query("SELECT kategorie, SUM(betrag) AS summe FROM Transaktionen WHERE Benutzer = \"$benutzer\" GROUP BY kategorie ORDER BY kategorie;");
        if ($ergebnis->num_rows > 0) {
            while ($zeile = $ergebnis->fetch_array()) {
                echo "<div class=\"spalten_index_h2\"> <h2>{$zeile['kategorie']} <br> {$zeile['summe']}€  </h2> </div>";
            }

        ?>

    </div>
    <div class="datensätze">
        <h2>Letzte Umbuchungen</h2>
        <?php
        $ergebnis = $mysqli->query("Select datum, betrag, zweck, kategorie FROM Transaktionen WHERE Benutzer = \"$benutzer\" ORDER BY datum DESC LIMIT 8;");
        while ($zeile = $ergebnis->fetch_array()) {
            $datum = new DateTime($zeile['datum']);
            echo "<strong>{$zeile['betrag']} €</strong>: {$zeile['zweck']} {$datum->format('d.m.Y')} {$zeile['kategorie']} <br>";
        }
        ?>

    </div>
    <div class="link_alle_datensätze_container">
        <a class="link_alle_datensätze" href="alle_datensätze.php">Alle Umbuchungen</a>
    </div>
    <div>
    <?php
    } else {
        echo "<h1>Du Hast noch keine Umbuchungen</h1>";
    }
        ?>
    </div>
        <div class="button-container">
            <a class="button" href="nachtrag_formular_php.php">Nachtrag</a>
            <a class="button" href="nachtrag_loeschen.php">Letzten Nachtrag löschen</a>
        </div>
    </div>
    <?php
}
else {
    ?>

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
            <h1>Wilkommen beim <br> TG-Manager</h1>
        <div class="button-container">
            <a class="button" href="anmelden.php">Anmelden</a>

            <a class="button" href="Registrieren.php">Registrieren</a>

        </div>
<div class="info_text">
    <span>
        Der Taschengeld-Manager ist eine kleine Webanwendung, die ihnen helfen soll ihr Taschengeld beziehungsweise ihren meist unübersichtlichen Kontostand zu Ordnen. <br>
Sie haben die Möglichkeit ihre monatlichen oder wöchentlichen Einnahmen einzustellen und können dazu noch Nachträge mit Ausgaben oder Sondereinnahmen einfügen. <br>
Alles wird ihnen dann geordnet in Kategorien angezeigt.
    </span>
</div>

    </div>




    <?php
}
?>
<div class="impressum">
    <a href="impressum.php">Impressum</a>
</div>
</body>
</html>
