
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
    <form id='searchform' action='benutzung.php' method='get'>
      <a href='index.php'>Alle Fitnesszentrum</a> ---
      Suche nach Kundennummer: 
      <input id='search' name='search' type='number' size='20' value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
      <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
        <a href='trainer.php'>Alle Trainers</a> ---
        <a href='kunde.php'>Alle Kunden</a> ---
        <a href='kabine.php'>Alle Kabinen</a> ---
        <a href='rezeptionistin.php'>Alle Rezeptionistinnen</a> ---
        <a href='abonnement.php'>Alle Abos</a> ---
                <a href='verkauf.php'>Alle Verkaeufe</a> ---

    </form>
  </div>
<?php
  // check if search view of list view
  if (isset($_GET['search'])) {
    $sql = "SELECT * FROM benutzung WHERE kundennr like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM benutzung";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>



<div>
  <form id='insertform' action='benutzung.php' method='get'>
    Neue Benutzung einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
        <th>abteilungsnr</th>

        <th>KundenNummer</th>
        <th>KabineNummer</th>
        <th>Beginnzeit</th>
        <th>Endzeit</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
       <td>
                   <input id='abteilungsnr' name='abteilungsnr' type='number' size='20' value='<?php echo $_GET['abteilungsnr']; ?>' />
                </td>
                <td>
                   <input id='kundennr' name='kundennr' type='number' size='20' value='<?php echo $_GET['kundennr']; ?>' />
                </td>
		<td>
		   <input id='kabinenr' name='kabinenr' type='number' size='20' value='<?php echo $_GET['kabinenr']; ?>' />
		</td>
		<td>
		   <input id='beginnzeit' name='beginnzeit' type='timestamp' size='10' value='<?php if (isset($_GET['beginnzeit'])) echo $_GET['beginnzeit']; ?>' />
		</td>
    <td>
		   <input id='endzeit' name='endzeit' type='timestamp' size='10' value='<?php if (isset($_GET['endzeit'])) echo $_GET['endzeit']; ?>' />
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
              <th>abteilungsnr</th>

        <th>KundenNummer</th>
        <th>KabineNummer</th>
        <th>Beginnzeit</th>
        <th>Endzeit</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {

    echo "<tr>";
        echo "<td>" . $row['ABTEILUNGSNR'] . "</td>";

    echo "<td>" . $row['KUNDENNR'] . "</td>";
        echo "<td>"  . $row['KABINENR'] . "</td>";

    echo "<td>" . $row['BEGINNZEIT'] . "</td>";
    echo "<td>" . $row['ENDZEIT']. "</td>";
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Benutzung(en) gefunden!</div>
<?php  oci_free_statement($stmt); ?>




<?php
  //Handle insert
  if (isset($_GET['abteilungsnr']))                                                                                                                                       
  {
    //Prepare insert statementd
    $sql = "INSERT INTO benutzung(abteilungsnr,kundennr,kabinenr,beginnzeit,endzeit) VALUES(". $_GET['abteilungsnr'] . ",". $_GET['kundennr'] . "," . $_GET['kabinenr'] . ",to_date('" . $_GET['beginnzeit'] . "','yyyy-mm-dd HH24:MI'),to_date('" . $_GET['endzeit'] . "','yyyy-mm-dd HH24:MI'))";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
   header("Refresh:0; url=benutzung.php");

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
