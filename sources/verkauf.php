
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
    <form id='searchform' action='verkauf.php' method='get'>
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
        <a href='abonnement.php'>Alle Abos</a> ---
    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM verkauf WHERE abonr like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM verkauf";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>


<div>
  <form id='insertform' action='verkauf.php' method='get'>
    Neuer Verkauf einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Abonummer</th>
        <th>Kundennummer</th>
        <th>SV-Nummer</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='abonr' name='abonr' type='number' size='10' value='<?php  echo $_GET['abonr']; ?>' />
                </td>
                <td>
                   <input id='kundennr' name='kundennr' type='number' size='20' value='<?php echo $_GET['kundennr']; ?>' />
                </td>
		<td>
		   <input id='svnummer' name='svnummer' type='number' size='20' value='<?php echo $_GET['svnummer']; ?>' />
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
        <th>Abonummer</th>
        <th>Kundennummer</th>
        <th>SV-Nummer</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['ABONR'] . "</td>";
    echo "<td>" . $row['KUNDENNR'] . "</td>";
    echo "<td>" . $row['SVNUMMER'] . "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Verkaeufe gefunden!</div>
<?php  oci_free_statement($stmt); ?>




<?php
  //Handle insert
  if (isset($_GET['abonr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO verkauf(abonr,kundennr,svnummer) VALUES(" . $_GET['abonr'] . ","  . $_GET['kundennr'] . "," . $_GET['svnummer'] . ")";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
   header("Refresh:0; url=verkauf.php");

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
