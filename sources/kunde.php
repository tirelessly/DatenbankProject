
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
  <div>
    <form id='searchform' action='kunde.php' method='get'>
      <a href='index.php'>Alle Fitnesszentrum</a> ---
      Suche nach Adresse: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
          <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
        <a href='trainer.php'>Alle Trainers</a> ---
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
    $sql = "SELECT * FROM kunde WHERE adresse like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM kunde";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>


<div>
  <form id='insertform' action='kunde.php' method='get'>
    Neue Kunde einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Kundennummer</th>
	      <th>Adresse</th>
	      <th>Telefonnummer</th>
	      <th>Abteilungsnummer</th>
	      <th>TrainerID</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='kundennr' name='kundennr' type='number' size='10' value='<?php echo $_GET['kundennr']; ?>' />
                </td>
                <td>
                   <input id='adresse' name='adresse' type='text' size='20' value='<?php if (isset($_GET['adresse'])) echo $_GET['adresse']; ?>' />
                </td>
		<td>
		   <input id='telefonnummer' name='telefonnummer' type='number' size='20' value='<?php echo $_GET['telefonnummer']; ?>' />
		</td>
		<td>
		   <input id='abteilungsnr' name='abteilungsnr' type='number' size='20' value='<?php echo $_GET['abteilungsnr']; ?>' />
		</td>
		<td>
		   <input id='trainerid' name='trainerid' type='number' size='5' value='<?php echo $_GET['trainerid']; ?>' />
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
        <th>Kundennummer</th>
	      <th>Adresse</th>
	      <th>Telefonnummer</th>
	      <th>Abteilungsnummer</th>
	      <th>TrainerID</th>

      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['KUNDENNR'] . "</td>";
    echo "<td>" . $row['ADRESSE'] . "</td>";
        echo "<td>" . $row['TELEFONNUMMER'] . "</td>";

    echo "<td>" . $row['ABTEILUNGSNR'] .  "</td>";
        echo "<td>" . $row['TRAINERID'] . "</td>";

    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Kunde(n) gefunden!</div>
<?php  oci_free_statement($stmt); ?>




<?php
  //Handle insert
  if (isset($_GET['kundennr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO kunde(kundennr,adresse,telefonnummer,abteilungsnr,trainerid) VALUES(" . $_GET['kundennr'] . ",'"  . $_GET['adresse'] . "'," . $_GET['telefonnummer'] . "," . $_GET['abteilungsnr'] . "," . $_GET  
    ['trainerid'] .")";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
           header("Refresh:0; url=kunde.php");

 	print("<br>");
    }
    //Print potential errors and warnings
    else{
       print($conn_err);
       print_r($insert_err);
       print("<br>");
    }
    oci_free_statement($insert);
  } 
?>


<?php
  
  

  
  // clean up connections
  //oci_free_statement($sproc);
  oci_close($conn);
?>
</body>
</html>
