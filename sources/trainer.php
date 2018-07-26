
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
    <form id='searchform' action='trainer.php' method='get'>
      <a href='index.php'>Alle Fitnesszentrum</a> ---
      Suche nach Nachname: 
      <input id='search' name='search' type='text' size='20' value='<?php if (isset($_GET['search'])) echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
        <a href='mitarbeiter.php'>Alle Mitarbeiter</a> ---
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
    $sql = "SELECT * FROM personal_trainer WHERE nachname like '%" . $_GET['search'] . "%'";
  } else {
    $sql = "SELECT * FROM personal_trainer";
  }

  // execute sql statement
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
?>




<div>
  <form id='insertform' action='trainer.php' method='get'>
    Neue Trainer einfuegen:
	<table style='border: 1px solid #DDDDDD'>
	  <thead>
	    <tr>
	      <th>Mitarbeiternummer</th>
        	      <th>TrainerID</th>

	      <th>Vorname</th>
	      <th>Nachname</th>
	    </tr>
	  </thead>
	  <tbody>
	     <tr>
	        <td>
	           <input id='mnr' name='mnr' type='number' size='10' value='<?php echo $_GET['mnr']; ?>' />
                </td>
                	<td>
		   <input id='trainerid' name='trainerid' type='number' size='20' value='<?php echo $_GET['trainerid']; ?>' />
		</td>
                <td>
                   <input id='vorname' name='vorname' type='text' size='20' value='<?php if (isset($_GET['vorname'])) echo $_GET['vorname']; ?>' />
                </td>
		<td>
		   <input id='nachname' name='nachname' type='text' size='20' value='<?php if (isset($_GET['nachname'])) echo $_GET['nachname']; ?>' />
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
        <th>Mitarbeiternummer</th>
        	      <th>TrainerID</th>

	      <th>Vorname</th>
	      <th>Nachname</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['MNR'] . "</td>";
        echo "<td>" . $row['TRAINERID'] . "</td>";

    echo "<td>" . $row['VORNAME'] . "</td>";
    echo "<td>" . $row['NACHNAME'] . "</td>";
  
    echo "</tr>";
  }
?>
    </tbody>
  </table>
<div>Insgesamt <?php echo oci_num_rows($stmt); ?> Trainer(s) gefunden!</div>
<?php  oci_free_statement($stmt); ?>



<?php
  //Handle insert
  if (isset($_GET['mnr'])) 
  {
    //Prepare insert statementd
    $sql = "INSERT INTO personal_trainer (mnr,trainerid,vorname,nachname) VALUES(" . $_GET['mnr'] . "," . $_GET['trainerid'] . ",'"  . $_GET['vorname'] . "','" . $_GET['nachname'] . "')";
    //Parse and execute statement
    $insert = oci_parse($conn, $sql);
    oci_execute($insert);
    $conn_err=oci_error($conn);
    $insert_err=oci_error($insert);
    if(!$conn_err & !$insert_err){
         header("Refresh:0; url=trainer.php");

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
