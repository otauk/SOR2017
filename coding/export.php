<?php
$projekt_id = $_POST["projekt_id"];
include("./conn.php");
// Liste der Projektdaten
$pro = $db->prepare("SELECT * FROM projekte");
$pro->execute();
$rcPro = $pro->rowCount();
$projekte = $pro->fetchAll();


if (($_SERVER["REQUEST_METHOD"]) == "POST") {
  try {
    $sListe = $db->prepare("SELECT name, vorname, klasse
    FROM anmeldungen
    WHERE projekt_id=?
    ORDER BY klasse, name
    ");
    $sListe->bindValue(1, $projekt_id);
    $sListe->execute();
    $rcsMP = $sListe->rowCount();
    $schuelerListe = $sListe->fetchAll();
    foreach ($schuelerListe as $schueler) {
      echo "Name: ".$schueler["name"].", Vorname: ".$schueler["vorname"].", Klasse: ".$schueler["klasse"]."<br/>";
    }
  }
  catch (PDOException $e) {
    echo $e->getMessage();
  }
}
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
    <title>Anmeldeverfahren SOR 2017_DEV</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
          <span class="navbar-brand">Anmeldung SOR 2017_DEV</span>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Übersicht</a></li>
            <li><a href="anmeldung.php">Neue Anmeldung</a></li>
            <li><a href="verwaltung.php">Verwaltung</a></li>
            <li><a href="export.php">Exporte</a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="">
        <h1>Export</h1>
				<table class="display" id="projekteTable">
					<thead>
						<tr>
							<th>Projekt</th>
							<th>Teilnehmer</th>
							<th>Export</th>
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
							?>
								<tr>
									<td><?=$projekt["titel"]; ?></td>
									<td><?=$b;?></td>
									<td>
                    <form class="export" name="export" action="exporte.php" method="post">
                      <input type="hidden" name="projekt_id" value="<?=$projekt["ID"]; ?>" />
                      <input type="hidden" name="projekt_titel" value="<?=$projekt["titel"]; ?>" />

                      <button type="submit"> <> </button>
                    </form>
								</tr>
						<?php } ?>
					</tbody>
				</table>
      </div>
    </div><!-- /.container -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
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
    <script>
 $( function() {
   $( ".accordion" ).accordion({
     collapsible:true,
     active: false
   });
 } );
 </script>
  </body>
</html>
