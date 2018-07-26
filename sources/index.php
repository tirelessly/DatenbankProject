
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
    <form id='searchform' action='index.php' method='get'>
      <a href='index.php'>Fitnesszentrum</a> ---
      Suche nach Name: 

      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
      <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
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
    $sql = "SELECT * FROM fitnesszentrum WHERE Name like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM fitnesszentrum";
  }

   if (isset($_GET['search2'])) {
    $sql = "SELECT * FROM fitnesszentrum WHERE Abteilungsnr like '%" . $_GET['search2'] . "%'";
  } else {
    $sql = "SELECT * FROM fitnesszentrum";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>

<div>
  <form id='insertform' action='index.php' method='get'>
    Neue Fitnesszentrum einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>AbteilungsNr</th>
	      <th>Name</th>
	      <th>PLZ</th>
	      <th>Ort</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='AbteilungsNr' name='AbteilungsNr' type='number' size='10' value='<?php if (isset($_GET['AbteilungsNr'])) echo $_GET['AbteilungsNr']; ?>' />
                </td>
                <td>
                   <input id='Name' name='Name' type='text' size='20' value='<?php if (isset($_GET['Name'])) echo $_GET['Name']; ?>' />
                </td>
		<td>
		   <input id='PLZ' name='PLZ' type='number' size='20' value='<?php if (isset($_GET['PLZ'])) echo $_GET['PLZ']; ?>' />
		</td>
		<td>
		   <input id='Ort' name='Ort' type='text' size='20' value='<?php if (isset($_GET['Ort'])) echo $_GET['Ort']; ?>' />
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
        <th>AbteilungsNr</th>
        <th>Name</th>
        <th>PLZ</th>
        <th>Ort</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['ABTEILUNGSNR'] ."</td>";
        echo "<td>" . $row['NAME'] ."</td>";
        echo "<td>" . $row['PLZ'] ."</td>";
        echo "<td>" . $row['ORT'] ."</td>";



    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt gibt es  <?php echo oci_num_rows($stmt); ?> Fitnesszentrum!</div>
<?php  oci_free_statement($stmt); ?>


<?php
  //Handle insert
  if (isset($_GET['AbteilungsNr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO fitnesszentrum VALUES(" . $_GET['AbteilungsNr'] . ",'"  . $_GET['Name'] . "'," . $_GET['PLZ'] . ",'" . $_GET['Ort'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
	print("Successfully inserted");
 	print("<br>");
header("Refresh:0; url=index.php");
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
