<?php
/*
 * Created on Tue July 23 2020
 * @author: Deepika
 * Details: Call Github API page
 */

include 'db.php';

//function to call Github API using CURL
// Pass Github API url
function getRepos($api_url)
{
	// create & initialize a curl session
	$curl = curl_init();

	// set api url with curl_setopt()
	curl_setopt($curl, CURLOPT_URL, $api_url);

	// Set a user agent
	curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

	// return the transfer as a string, also with setopt()
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	// curl_exec() executes the curl session
	$json_data = curl_exec($curl);

	// close curl resource to free up system resources
	curl_close($curl);

	// Decode JSON data into PHP array
	$response_data = json_decode($json_data);
	return $response_data;
}
//call get repositories function here
$response1 = getRepos('https://api.github.com/search/repositories?q=topic:PHP+language:PHP');
//initialize arrays to store repos urls
$reposArray = [];
$repositoriesArray = [];

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
else{
	//access all the data in the array with a foreach loop
  foreach ($response1->items as $item)
	{
		//check for null repositoryID
		if(!is_null($item->id))
		{//insert api response into an array
			array_push($repositoriesArray, array(
        "repoID" => $item->id,
        "repoName" => addslashes($item->name),
        "repoURL" => $item->html_url,
				"repoCreatedDate" => $item->created_at,
				"repopushedDate" => $item->pushed_at,
				"Description" => addslashes($item->description),
				"Stars" => $item->stargazers_count,
				"Language" => $item->language,
				"Forks" => $item->forks_count

    ));
			//Insert repos from each repository into an array to get details from API
			if (!in_array($item->owner->repos_url, $reposArray))
	      array_push($reposArray,$item->owner->repos_url);
		}

	}
  foreach ($reposArray as $repo)
	{
		//cal API to get Repo Details
  	$response2 = getRepos($repo);
    foreach($response2 as $details)
  	 {
         //check for null repoID
				 if(!empty($details->id))
				 {
					 //insert API response into an Array
					 array_push($repositoriesArray, array(
		        "repoID" => $details->id,
		        "repoName" => addslashes($details->name),
		        "repoURL" => $details->html_url,
		 				"repoCreatedDate" => $details->created_at,
		 				"repopushedDate" => $details->pushed_at,
		 				"Description" => addslashes($details->description),
		 				"Stars" => $details->stargazers_count,
		 				"Language" => $details->language,
		 				"Forks" => $details->forks_count

		     ));
         }
			}

  	}
		$query = '';
		//insert values into database;
		foreach($repositoriesArray as $data)
		{//check before inserting to avoid duplicate entries
			$checkquery = "SELECT * FROM repos where repositoryID=".$data["repoID"];
		  if($result = mysqli_query($conn, $checkquery)){
		      if(mysqli_num_rows($result)==0){
						 $repo_id_clean = mysqli_real_escape_string($conn, $data["repoID"]);
						 $repo_name_clean = mysqli_real_escape_string($conn, $data["repoName"]);
						 $repo_url_clean = mysqli_real_escape_string($conn, $data["repoURL"]);
					   $repo_createddate_clean = mysqli_real_escape_string($conn, $data["repoCreatedDate"]);
					   $repo_pushdate_clean = mysqli_real_escape_string($conn, $data["repopushedDate"]);
					   $repo_desc_clean = mysqli_real_escape_string($conn, $data["Description"]);
						 $repo_stars_clean = mysqli_real_escape_string($conn, $data["Stars"]);
						 $repo_language_clean = mysqli_real_escape_string($conn, $data["Language"]);
						 $repo_forks_clean = mysqli_real_escape_string($conn, $data["Forks"]);

					   if($repo_id_clean)
					   {
							 //prepare insert query and append all queries to query variable
					    $query .= '
					    INSERT INTO repos (repositoryID, repoName,repoURL,createdDate,lastpushDate,Description,Stars,Language,Forks)
					    VALUES("'.$repo_id_clean.'", "'.$repo_name_clean.'", "'.$repo_url_clean.'", "'.$repo_createddate_clean .'", "'.$repo_pushdate_clean.'", "'.$repo_desc_clean.'", "'.$repo_stars_clean.'", "'.$repo_language_clean.'", "'.$repo_forks_clean.'");';

					   }
					 }
				 }
			 }
			if($query != '')
				{//execute multiple insert queries at once
					   if(mysqli_multi_query($conn, $query))
					   {
							 $response_array['status'] = 'Item Data Inserted';
         			 echo json_encode($response_array);
					   }
					   else
					   {
							 $response_array['error'] = 'Error';
         			 echo json_encode($response_array);
					   }
				 }
				else
				 {
						 $response_array['error'] = 'All Fields are Required';
						 echo json_encode($response_array);
				 }

}

?>
