
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
    <form id='searchform' action='kabine.php' method='get'>
      <a href='index.php'>Alle Fitnesszentrum</a> ---
      Suche nach Geschlecht: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
  <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
        <a href='trainer.php'>Alle Trainers</a> ---
        <a href='kunde.php'>Alle Kunden</a> ---
        <a href='rezeptionistin.php'>Alle Rezeptionistinnen</a> ---
        <a href='benutzung.php'>Alle Benutzungen</a> ---
        <a href='abonnement.php'>Alle Abos</a> ---
                <a href='verkauf.php'>Alle Verkaeufe</a> ---

    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM umkleidekabine WHERE geschlecht like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM umkleidekabine";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);


?>

<div>
  <form id='insertform' action='kabine.php' method='get'>
    Neue Kabine einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Abteilungsnummer</th>
	      <th>Kabinenummer</th>
	      <th>Geschlecht</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='abteilungsnr' name='abteilungsnr' type='number' size='10' value='<?php echo $_GET['abteilungsnr']; ?>' />
                </td>
                <td>
                   <input id='kabinenr' name='kabinenr' type='number' size='20' value='<?php echo $_GET['kabinenr']; ?>' />
                </td>
		<td>
		   <input id='geschlecht' name='geschlecht' type='text' size='20' value='<?php if (isset($_GET['geschlecht'])) echo $_GET['geschlecht']; ?>' />
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
        <th>Abteilungsnummer</th>
        <th>Kabinenummer</th>
        <th>Geschlecht</th>

      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['ABTEILUNGSNR'] . "</td>";
    echo "<td>" . $row['KABINENR'] .  "</td>";
        echo "<td>" . $row['GESCHLECHT'] . "</td>";

    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Kabine(n) gefunden!</div>
<?php  oci_free_statement($stmt); ?>




<?php
  //Handle insert
  if (isset($_GET['abteilungsnr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO  umkleidekabine(abteilungsnr,kabinenr,geschlecht) VALUES(" . $_GET['abteilungsnr'] . ","  . $_GET['kabinenr'] . ",'" . $_GET['geschlecht'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
         header("Refresh:0; url=kabine.php");

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
