<?php
/*
 * Created on Tue July 25 2020
 * @author: Deepika
 * Details: Get repo details from DB page
 */

include 'db.php';
//query to select remaining repository details
$sql = "SELECT * FROM repos where ID=".$_POST['repoid'];
 	$res = mysqli_query($conn, $sql);
 	$returnarray = array();
 	while($row = mysqli_fetch_assoc($res)) {
    //store results in an array
 		$rowarray = array(
 			"description" => $row['Description'],
      "stars" => $row['Stars'],
      "language" => $row['Language'],
      "forks" => $row['Forks']
 		);
 		$returnarray[] = $rowarray;
 	}
 	mysqli_free_result($res);
 	echo json_encode($returnarray);//send json response back to index page
 ?>
