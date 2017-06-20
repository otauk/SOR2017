<?
//var_dump($_POST);
// Schülerdaten splitten
$schueler = explode("|", $_POST["schueler"]);
$vorname = $schueler[0];
$name = $schueler[1];
$schueler_id = $schueler[2];

$database = "anmeldungen";

//Daten gesendet?
if (($_SERVER["REQUEST_METHOD"]) == "POST") {
	require("validation.php");
}
  // DB
  include("./conn.php");
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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

		<script>
		function showUser(str) {
		    if (str == "") {
		        document.getElementById("ajaxCall").innerHTML = "";
		        return;
		    } else {
		        if (window.XMLHttpRequest) {
		            // code for IE7+, Firefox, Chrome, Opera, Safari
		            xmlhttp = new XMLHttpRequest();
		        } else {
		            // code for IE6, IE5
		            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		        }
		        xmlhttp.onreadystatechange = function() {
		            if (this.readyState == 4 && this.status == 200) {
		                document.getElementById("ajaxCall").innerHTML = this.responseText;
		            }
		        };
		        xmlhttp.open("GET","getName.php?q="+str,true);
		        xmlhttp.send();
		    }
		}
		</script>


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
	$kListe = $db->prepare("SELECT klasse FROM schueler GROUP BY klasse");
	$kListe->execute();
	$klassen = $kListe->fetchAll();
 ?>


    <div class="container">
    	<h1>Neue Anmeldung</h1>
        <div class="confirmation"><?=$confirmation; ?></div>
				<hr />
        <form class="anmeldung" name="anmeldung" action="anmeldung.php" method="post">
          <h2>Schülerdaten</h2>
					<p>
						<label class="schueler" for="klasse">Klasse:</label>
						<select name="klasse" onchange="showUser(this.value)">
							<option value='Auswahl...'>Auswahl...</option>
	            <?php foreach ($klassen as $klassenName) {
	              echo "<option value='$klassenName[0]' $sel>$klassenName[0]</option>";
	            }
	            ?>
	          </select>
					</p>
					<p>
						<div id="ajaxCall"></div>
					</p>
          <hr />
          <h2>Projekte</h2>
          <div class="projekte">

	          <?php
						// Projektdaten
						$stmt = $db->prepare("SELECT * FROM projekte ORDER BY ID");
						$stmt->execute();
						$rows_gesamt = $stmt->rowCount();
						$projects = $stmt->fetchAll();

						foreach($projects as $project) {
								// Freie Plätze
								$a = $project["maxTN"];
								$b = $project["ID"];
								$stmt = $db->prepare("SELECT * FROM anmeldungen WHERE projekt_id = $b");
								$stmt->execute();
								$b = $stmt->rowCount();
								$verfuegbar = $a - $b;
								if ($verfuegbar<=0) {
									$display = "none";
								} else $display="";
						?>
	          <div class="projekt" style="display:<?=$display;?>">
	            <div class="titel">
	            	<?=$project["titel"];?>
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
										<input name='projekt' type='radio' value='<?=$project["ID"] ?>' onclick="this.form.submit();">
										<span>Anmelden</span>
									</label>
								</div>
	            </div>
	          </div>
	          	<?php } ?>
          </div>
        </form>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>
