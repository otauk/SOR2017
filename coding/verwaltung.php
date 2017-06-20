<?php
 // var_dump($_POST);
 include("./conn.php");
 // Daten gesendet?
 if (($_SERVER["REQUEST_METHOD"]) == "POST") {
    $sid = $_POST["id"];
   // Angmeldet zurücksetzen
    $reset = $db->prepare("UPDATE schueler SET angemeldet = 0 WHERE ID=?");
    $reset->bindParam(1, $sid);
    $reset->execute();
    // Löschen aus anmeldungen
    $delete = $db->prepare("DELETE FROM anmeldungen WHERE schueler_id = ?");
    $delete->bindParam(1, $sid);
    $delete->execute();
 }

$sMP = $db->prepare("SELECT a.name, a.vorname, a.klasse, a.schueler_id, p.titel
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
            <li><a href="#">Verwaltung</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="">
        <h1>Verwaltung</h1>
				<p>
					Beim Klick auf den Button wird der Anmeldestatus der Schülerin/des Schülers zurückgesetzt.
				</p>
				<hr>
				<h2>Schüler</h2>
				<table class="display" id="schuelerTable">
					<thead>
						<tr>
							<th>Name</th>
							<th>Klasse</th>
              <th>Projekt</th>
              <th>Löschen</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($sMitProjekt as $schuelerEinzeln) {
              $n = $schuelerEinzeln["name"].", ".$schuelerEinzeln["vorname"];
							?>
								<tr>
									<td><?=$n;?></td>
									<td><?=$schuelerEinzeln["klasse"]; ?></td>
                  <td><?=$schuelerEinzeln["titel"]; ?></td>
                  <td>
                    <form class="schueler" name="schueler" action="verwaltung.php" method="post">
                      <input type="hidden" name="id" value="<?=$schuelerEinzeln["schueler_id"]; ?>" />
                      <input type="hidden" name="name" value="<?=$n;?>" />
                      <input type="hidden" name="angemeldet" value="0" />
                      <button type="submit"> X </button>
                  </form>
                  </td>

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
		} );
		</script>
  </body>
</html>
