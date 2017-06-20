<?php
// Welche Klasse?
$q = $_GET['q'];
// Welche Jahrgangsstufe?
$y = explode(".", $q);
include("./conn.php");
// Alle Schüler einer Klasse ausgeben
  try {
    $stmt = $db->prepare("SELECT * FROM schueler WHERE klasse = ? AND angemeldet = ?");
    $stmt->bindValue(1, $q);
    $stmt->bindValue(2, 0);
    $stmt->execute();
    $schuelerNamen = $stmt->fetchAll();
    $rc = $stmt->rowCount();
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
?>
<label class="schueler" for="schueler">Schüler/in:</label>
<select name="schueler">
  <?php
  // Keine übrig? Dann Fehlermeldung
  if ($rc==0) {
    echo "<option>Alle Schüler angemeldet, weiter zur nächsten Klasse :)</option>";
  }
  else {
    foreach ($schuelerNamen as $schuelerName) {
      $vorname = $schuelerName["vorname"];
      $nachname = $schuelerName["name"];
      $i = $schuelerName["ID"];
      echo "<option value='$vorname|$nachname|$i'>$nachname, $vorname</option>";
    }
  }
  ?>
</select>
<hr />
<?php
// Alle Projekte abfragen, die für die Jahrgangsstufe möglich sind
try {
  $pro = $db->prepare("SELECT * FROM projekte WHERE ? BETWEEN rangeStart AND rangeEnd");
  $pro->bindValue(1, $y[0]);
  $pro->execute();
  $projekte = $pro->fetchAll();
  $rcPro = $pro->rowCount();
}
catch (PDOException $e) {
  echo $e->getMessage();
}?>
<h2>Projekte</h2>
<div class="projekte">
<?php
foreach ($projekte as $projekt) {
  $a = $projekt["maxTN"];
  $b = $projekt["ID"];
  $platzabfrage = $db->prepare("SELECT * FROM anmeldungen WHERE projekt_id = $b");
  $platzabfrage->execute();
  $b = $platzabfrage->rowCount();
  $verfuegbar = $a - $b;
  if ($verfuegbar<=0) {
    $display = "none";
  } else $display="";
?>
  <div class="projekt" style="display:<?=$display;?>">
    <div class="titel">
    <?=$projekt["titel"];?>
  </div>
    <hr />
    <div class="plaetze">
    Freie Plätze: <strong><?=$verfuegbar;?></strong>
  </div>
    <div style="clear:both;">
    </div>
    <hr />
    <div class="anmeldung">
    <div class='anmeldenButton'>
      <label>
        <input name='projekt' type='radio' value='<?=$projekt["ID"] ?>' onclick="this.form.submit();">
        <span>Anmelden</span>
      </label>
    </div>
  </div>
  </div>
<?php } ?>
</div>
