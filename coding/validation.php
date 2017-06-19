<?php
if($_POST["klasse"]=="Auswahl...") {$fehler .= "Bitte Klasse auswählen<br/>";} else {$klasse = validate($_POST["klasse"]);}
if($_POST["schueler"]=="Alle Schüler angemeldet, weiter zur nächsten Klasse :)") {$fehler .= "Bitte eine Schülerin/einen Schüler auswählen<br/>";} else {$name = validate($_POST["schueler"]);}
if(empty($_POST["projekt"])) {$fehler .= "Kein Projekt gewählt!<br/>";} else {$projekt = validate($_POST["projekt"]);}

include("./conn.php");
$stmt = $db->prepare("SELECT * FROM $database WHERE klasse= ? AND name = ? LIMIT 1");
$stmt->bindValue(1, $klasse, PDO::PARAM_STR);
$stmt->bindValue(2, $name, PDO::PARAM_STR);
$stmt->execute();
$rows = $stmt->rowCount();
if ($rows>0) {$fehler .= "Die Schülerin/der Schüler <strong>$name</strong> aus der Klasse <strong>$klasse</strong> ist bereits für ein Projekt angemeldet.";}

// Wenn Fehler vorliegen -> Ausgabe
if($fehler) {$confirmation = "<div class='alert alert-danger'>$fehler</div>";}

// ...sonst Eintrag vornehmen
else {
  try {
    $stmt = $db->prepare(	"INSERT INTO $database
                (klasse, name, projekt_id)
              VALUES
                (:klasse, :name, :projekt)
              ");
    $stmt->bindParam(':klasse', $klasse);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':projekt', $projekt);

    $stmt2 = $db->prepare(
      "UPDATE schueler
      SET angemeldet=1
      WHERE name = ?");
      // Name muss getrennt werden!
      $nameShort = explode(',', $name);
    $stmt2->bindValue(1, $nameShort[0]);


      // Eintrag erfolgreich?
    if($stmt->execute() AND $stmt2->execute()) {

      $confirmation = "
      <div class='alert alert-success'>
      <p>Die Daten wurden erfolgreich übernommen.</p>
      <p>Die Seite wird neu geladen für den nächsten Eintrag.</p>
      </div>
      ";

      header("Refresh: 3;");
    }
    else {$confirmation = "<div class='alert alert-danger'>Fehler beim Eintrag in die Datenbank. Bitte wenden Sie sich an den Support.</div>";}
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}

// Funktion zum Überarbeiten der Daten
function validate($data) {
$data = trim($data);
$data = stripslashes($data);
$data = htmlspecialchars($data);
return $data;
}


?>
