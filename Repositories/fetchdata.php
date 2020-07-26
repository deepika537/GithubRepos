<?php
/*
 * Created on Tue July 24 2020
 * @author: Deepika
 * Details: prepare Data table using database content
 */

include 'db.php';
//select data from database
$selectquery = "SELECT * FROM repos";
$result = mysqli_query($conn, $selectquery);
//Table header
$output = '<table id="repositories_data" class="table table-striped table-bordered">
     <thead>
          <tr>
             <td style="display:none"></td>
              <td>Details</td>
               <td>ID</td>
               <td>Name</td>
               <td>URL</td>
               <td>CreatedDate</td>
               <td>PublishedDate</td>
          </tr>
     </thead>';
//create table rows with database content
while($row = mysqli_fetch_array($result))
{
     $output.= '
     <tr>
          <td style="display:none">'.$row["ID"].'</td>
          <td class="details-control"></td></td>
          <td>'.$row["repositoryID"].'</td>
          <td>'.$row["repoName"].'</td>
          <td>'.$row["repoURL"].'</td>
          <td>'.$row["createdDate"].'</td>
          <td>'.$row["lastpushDate"].'</td>

     </tr>
     ';
}
echo $output;//send data back to index page
//close db connection
$conn -> close();
?>
