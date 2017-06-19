<?php
// var_dump($_POST);
include("./conn.php");
// Liste der Projektdaten
$pro = $db->prepare("SELECT * FROM projekte");
$pro->execute();
$rcPro = $pro->rowCount();
$projekte = $pro->fetchAll();
// Schüler ohne Pojekt
$sOP = $db->prepare("SELECT * FROM schueler WHERE angemeldet = 0");
$sOP->execute();
$rcsOP = $sOP->rowCount();
$sOhneProjekt = $sOP->fetchAll();
// Schüler mit Projekt
$sMP = $db->prepare("SELECT a.name, a.klasse, p.titel
FROM anmeldungen a
LEFT JOIN projekte p
ON a.projekt_id  = p.ID");
$sMP->execute();
$rcsMP = $sMP->rowCount();
$sMitProjekt = $sMP->fetchAll();

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Anmeldeverfahren SOR 2017</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
		<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class="navbar navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <span class="navbar-brand">Anmeldung SOR 2017</span>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Übersicht</a></li>
            <li><a href="anmeldung.php">Neue Anmeldung</a></li>
            <li><a href="verwaltung.php">Verwaltung</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>


<?php
  // Liste der Klassen
  $klassen = array('Auswahl...','5a', '5b','5c', '6a');
 ?>


    <div class="container">
      <div class="">
        <h1>Übersicht</h1>
				<p>
					Es liegen bisher insgesamt <strong><?=$rcsMP; ?></strong> Anmeldungen in <strong><?=$rcPro; ?></strong> Projekten vor.
				</p>
				<hr>
				<h2>Projekte</h2>
				<table class="display" id="projekteTable">
					<thead>
						<tr>
							<th>Titel</th>
							<th>Teilnehmer</th>
							<th>Freie Plätze</th>
							<th>maxTN</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($projekte as $projekt) {
							$a = $projekt["maxTN"];
							$b = $projekt["ID"];
							$stmt = $db->prepare("SELECT * FROM anmeldungen WHERE projekt_id = $b");
							$stmt->execute();
							$b = $stmt->rowCount();
							$verfuegbar = $a - $b;
							?>
								<tr>
									<td><?=$projekt["titel"]; ?></td>
									<td><?=$b;?></td>
									<td><?=$verfuegbar;?></td>
									<td><?=$projekt["maxTN"]; ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
				<hr />
				<h2>Schüler ohne Projekt (akuell: <?=$rcsOP; ?>)</h2>
				<table class="display" id="schuelerTable">
					<thead>
						<tr>
							<th>Name</th>
							<th>Klasse</th>
              <th>Klassenlehrer/in</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($sOhneProjekt as $sOhneProjektEinzeln) {
              $nOP = $sOhneProjektEinzeln["name"].", ".$sOhneProjektEinzeln["vorname"];
							?>
								<tr>
									<td><?=$nOP; ?></td>
									<td><?=$sOhneProjektEinzeln["klasse"]; ?></td>
                  <td><?=$sOhneProjektEinzeln["klassenlehrer"]; ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
				<hr />
        <h2>Schüler mit Projekt (aktuell: <?=$rcsMP; ?>)</h2>
				<table class="display" id="schuelerTableProjekte">
					<thead>
						<tr>
							<th>Name</th>
							<th>Klasse</th>
              <th>Projekt</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($sMitProjekt as $sMitProjektEinzeln) {
              $nMP = $sMitProjektEinzeln["name"].", ".$sMitProjektEinzeln["vorname"];
							?>
								<tr>
									<td><?=$sMitProjektEinzeln["name"]; ?></td>
									<td><?=$sMitProjektEinzeln["klasse"]; ?></td>
                  <td><?=$sMitProjektEinzeln["titel"]; ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
				<hr />
      </div>
    </div><!-- /.container -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
		<script>
		$(document).ready(function() {
		    $('#projekteTable').DataTable( {
		        "paging":   false,
		        "info":     false,
						"searching": 	false
		    } );

				$('#schuelerTable').DataTable( {
					 "paging":   false,
					 "info":     false,
					 "searching": 	false,
					 "order": [[ 1, "asc" ]]
			 } );
       $('#schuelerTableProjekte').DataTable( {
          "paging":   false,
          "info":     false,
          "searching": 	false,
          "order": [[ 1, "asc" ]]
      } );
		} );
		</script>
  </body>
</html>
