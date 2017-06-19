<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
$q = $_GET['q'];
include("./conn.php");
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

<select name="schueler">
  <?php
  if ($rc==0) {
    echo "<option>Alle Schüler angemeldet, weiter zur nächsten Klasse :)</option>";
  }
  else {
    foreach ($schuelerNamen as $schuelerName) {
      $n = $schuelerName["name"];
      if($schuelerName==$name) {
        $sel = "selected";
      } else $sel='';
      echo "<option value='$n' $sel>$n</option>";
    }
  }


  ?>
</select>
</body>
</html>
