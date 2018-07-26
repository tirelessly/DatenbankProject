
<?php
  $user = '';
  $pass = '';
  $database = 'lab';
 
  // establish database connection
  $conn = oci_connect($user, $pass, $database);
  if (!$conn) exit;
?>


<html>
<head>
</head>
<body>

<body>
  <div>
    <form id='searchform' action='mitarbeiter.php' method='get'>
      <a href='index.php'>Alle Fitnesstzentrum</a> ---
      Suche nach Adresse: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
        <a href='trainer.php'>Alle Trainers</a> ---
        <a href='kunde.php'>Alle Kunden</a> ---
        <a href='kabine.php'>Alle Kabinen</a> ---
        <a href='rezeptionistin.php'>Alle Rezeptionistinnen</a> ---
        <a href='benutzung.php'>Alle Benutzungen</a> ---
        <a href='abonnement.php'>Alle Abos</a> ---
                <a href='verkauf.php'>Alle Verkaeufe</a> ---




    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM mitarbeiter WHERE adresse like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM mitarbeiter";
  }
 
  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>



<div>
  <form id='insertform' action='mitarbeiter.php' method='get'>
    Neue Mitarbeiter einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>

	      <th>Adresse</th>
	      <th>Geburtsdatum(yyyy-mm-dd)</th>
	      <th>LeiterMNr</th>
	      <th>Abteilungsnr</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
  
	        <td>
	           <input id='adresse' name='adresse' type='text' size='10' value='<?php if (isset($_GET['adresse'])) echo $_GET['adresse']; ?>' />
                </td>
                	<td>
		   <input id='geburtsdatum' name='geburtsdatum' type='date' size='20' value='<?php if (isset($_GET['geburtsdatum'])) echo $_GET['geburtsdatum']; ?>' />
		</td>
                <td>
                   <input id='leitermnr' name='leitermnr' type='number' size='20' value='<?php echo $_GET['leitermnr']; ?>' />
                </td>
		<td>
		   <input id='abteilungsnr' name='abteilungsnr' type='number' size='20' value='<?php echo $_GET['abteilungsnr']; ?>' />
		</td>
	      </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Insert!' />
  </form>
 
</div>








  <table style='border: 1px solid #DDDDDD'>
    <thead>
      <tr>
              <th>mnr</th>

        <th>Adresse</th>
        <th>Geburtsdatum</th>
        <th>LeiterMNr</th>
        <th>Abteilungsnr</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
        echo "<td>" . $row['MNR'] . "</td>";

    echo "<td>" . $row['ADRESSE'] . "</td>";
    echo "<td>" . $row['GEBURTSDATUM'] .  "</td>";
        echo "<td>"  . $row['LEITERMNR'] . "</td>";

    echo "<td>" . $row['ABTEILUNGSNR'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>


 <div>Insgesamt <?php echo oci_num_rows($stmt); ?> Mitarbeiter gefunden!</div>

<?php  oci_free_statement($stmt); ?>


<?php
  //Handle insert
  if (isset($_GET['adresse'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO mitarbeiter (Adresse, Geburtsdatum, LeiterMNr, AbteilungsNr)  VALUES('" . $_GET['adresse'] . "',to_date('" . $_GET['geburtsdatum'] . "','yyyy-mm-dd')," . $_GET['leitermnr'] . "," . $_GET['abteilungsnr'] . ")";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
   header("Refresh:0; url=mitarbeiter.php");

    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
    oci_free_statement($insert);
  } 

  // clean up connections
 // oci_free_statement($sproc);
  oci_close($conn);
?>
</body>
</html>
