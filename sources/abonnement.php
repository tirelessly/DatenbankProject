
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
    <form id='searchform' action='abonnement.php' method='get'>
      <a href='index.php'>Alle Fitnesszentrum</a> ---
      Suche nach Abonummer: 
      <input id='search' name='search' type='number' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
      <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
        <a href='trainer.php'>Alle Trainers</a> ---
        <a href='kunde.php'>Alle Kunden</a> ---
        <a href='kabine.php'>Alle Kabinen</a> ---
        <a href='rezeptionistin.php'>Alle Rezeptionistinnen</a> ---
        <a href='benutzung.php'>Alle Benutzungen</a> ---
                <a href='verkauf.php'>Alle Verkaeufe</a> ---

    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM abonnementstyp WHERE abonr like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM abonnementstyp";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>


<div>
  <form id='insertform' action='abonnement.php' method='get'>
    Neues Abo einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Abonr</th>
	      <th>Kuendigungsfrist</th>
	      <th>Geschaeftsbedingungen</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='abonr' name='abonr' type='number' size='10' value='<?php echo $_GET['abonr']; ?>' />
                </td>
                <td>
                   <input id='kuendigungsfrist' name='kuendigungsfrist' type='date' size='20' value='<?php if (isset($_GET['kuendigungsfrist'])) echo $_GET['kuendigungsfrist']; ?>' />
                </td>
		<td>
		   <input id='geschaeftsbedingunden' name='geschaeftsbedingunden' type='text' size='20' value='<?php if (isset($_GET['geschaeftsbedingunden'])) echo $_GET['geschaeftsbedingunden']; ?>' />
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
        <th>Abonr</th>
        <th>Kuendigungsfrist</th>
        <th>Geschaeftsbedingungen</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['ABONR'] . "</td>";
    echo "<td>" . $row['KUENDIGUNGSFRIST'] . "</td>"; 
    echo "<td>" . $row['GESCHAEFTSBEDINGUNDEN'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Abo(s) gefunden!</div>
<?php  oci_free_statement($stmt); ?>




<?php
  //Handle insert
  if (isset($_GET['abonr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO abonnementstyp(abonr,kuendigungsfrist,geschaeftsbedingunden) VALUES(" . $_GET['abonr'] . ",to_date('" . $_GET['kuendigungsfrist'] . "','yyyy-mm-dd'),'" . $_GET['geschaeftsbedingunden'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
      header("Refresh:0; url=abonnement.php");

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
