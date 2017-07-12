<?php

session_start();
#ini_set('display_errors', true);

$benutzer = $_SESSION["benutzer_id"];
$zweck = "Automatische Buchung";

function finde_regel($intervall) {
    switch ($intervall){
        case 'wöchentlich' ;
        $regel = 'next monday';
        break;

        case 'monatlich';
        $regel = 'first day of next month';
        break;
    }
    return $regel;
}

function berechne_ausfuehrungszeitpunkte($regel, $letzteBuchung) {
    $datum = new DateTime($letzteBuchung);
    $heute = new DateTime();


    while (true) {
    $datum->modify($regel);

    if ($datum > $heute) {
    break;
    }
        $offeneBuchungszeitpunkte[] = $datum->format('Y-m-d');
}
return $offeneBuchungszeitpunkte;
}

function buchung_nachtragen($datum, $betrag, $zweck, $kategorie, $benutzer, $mysqli) {

        $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie, benutzer) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sssss', $datum, $betrag, $zweck, $kategorie, $benutzer);
        $stmt->execute();

        $sql = "UPDATE Abo SET datum = ? WHERE Benutzer = ? AND kategorie = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sss', $datum, $benutzer, $kategorie);
        $stmt->execute();

}

$mysqli = new mysqli("localhost", "root", "stefan", "tg_manager");
if ($mysqli->connect_error) {
    echo "Fehler bei Verbindung:" . mysqli_connect_error();
    exit();
}

$ergebnis = $mysqli->query("SELECT kategorie, betrag, intervall, datum FROM Abo WHERE benutzer = \"$benutzer\";");

while ($zeile = $ergebnis->fetch_array()) {

    $kategorie = $zeile['kategorie'];
    $betrag = $zeile['betrag'];
    $intervall = $zeile['intervall'];
    $letzteBuchung = $zeile['datum'];
    if ($zeile['betrag']) {

        $regel = finde_regel($intervall);

        $offeneBuchungszeitpunkte = berechne_ausfuehrungszeitpunkte($regel, $letzteBuchung);

        foreach ($offeneBuchungszeitpunkte as $datum) {
            buchung_nachtragen($datum, $betrag, $zweck, $kategorie, $benutzer, $mysqli);
        }

    }
    else {
        exit;
    }
}



//while (true) {
//    $zeile = $ergebnis->fetch_array();
//    $kategorie = $zeile['kategorie'];
//    $betrag = $zeile['betrag'];
//    $intervall = $zeile['intervall'];
//    $letzteBuchung = $zeile['datum'];
//    $datum_1 = new DateTime($letzteBuchung);
//    $datum_2 = new DateTime($letzteBuchung);
//    $next_monday = $datum_1->modify('next monday');
//    $next_month = $datum_2->modify('first day of next month');
//
//
//    if ($intervall == "wöchentlich" && $next_monday < $aktuell) {
//
//        $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie, benutzer) VALUES (?, ?, ?, ?, ?)";
//        $stmt = $mysqli->prepare($sql);
//        $stmt->bind_param('sssss', $next_monday->format('Y-m-d'), $betrag, $zweck, $kategorie, $benutzer);
//        $insertSuccessful = $stmt->execute();
//
//        $sql = "UPDATE Abo SET datum = ? WHERE Benutzer = ? AND kategorie = ?";
//        $stmt = $mysqli->prepare($sql);
//        $stmt->bind_param('sss', $next_monday->format('Y-m-d'), $benutzer, $kategorie);
//        $insertSuccessful = $stmt->execute();
//    }
//   else if ($intervall == "monatlich" && $next_month < $aktuell) {
//
//        $sql = "INSERT INTO Transaktionen (datum, betrag, zweck, kategorie, benutzer) VALUES (?, ?, ?, ?, ?)";
//        $stmt = $mysqli->prepare($sql);
//        $stmt->bind_param('sssss', $next_month->format('Y-m-d'), $betrag, $zweck, $kategorie, $benutzer);
//        $insertSuccessful = $stmt->execute();
//
//        $sql = "UPDATE Abo SET datum = ? WHERE Benutzer = ? AND kategorie = ?";
//        $stmt = $mysqli->prepare($sql);
//        $stmt->bind_param('sss', $next_month->format('Y-m-d'), $benutzer, $kategorie);
//        $insertSuccessful = $stmt->execute();
//    }
//    else {
//        break;
//    }
//}
?>
