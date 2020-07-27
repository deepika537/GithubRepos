
I created a simple interface to get most popular PHP repositories from GitHub API.

I used the following languages and frameworks to create this interface:
PHP, MySQL, Javascript, JQuery, AJAX, Bootstrap and DataTables and XAMPP.

I followed the steps shown below to create an interface using MacBook Pro laptop (macOS Mojave version 10.14.5). 

To replicate the creation of the application, first you need to clone the repository from my GitHub account at https://github.com/deepika537/GithubRepos . 

The following steps are recommended.

1.	Install XAMPP webserver.
2.	Create Repositories folder in Applications/XAMPP/xamppfiles/htdocs
3.	Upload all PHP files and resources folder to Repositories folder on XAMPP. Following is the explanation of all the PHP files
  1.Db.php => It establishes the connection with the database using connection string variables.
  2.Index.php => It has references to all JavaScript and CSS libraries that are required to create the interface. It also calls all other PHP pages to get the Repository details from the GitHub API, insert repository details into the database, and fetch details from the database and display on the index page.
  3.Insertrepos.php => It calls GitHub API insert details into the database.
  4.GitHub API call: I used this following link to call GitHub API. https://api.github.com/search/repositories?q=topic:PHP+language:PHP
  5.Fetch.php => It fetches Repository details from Database and creates the DataTables.
  6.Details.php => It fetches the remaining hidden repository details from the database and displays on the interface when the user clicks on small ‘+’ green color icon.
4.	Resources folder has images used in this project
5.	Create the database in MySQL (http://localhost/phpmyadmin)
  -Database name: repositories;
6.	Create table in the database
  -Tablename: repos
7.	Create 10 columns, including ID, repositoryID, repoName, repoURL, createdDate, 
lastpushDate, Description, Starts, Language, and Forks. 
8.	If you want to skip the steps 6 and 7 shown above, you just need to upload repos.sql file (from my GitHub account) to MySQL Database.
9.	Please note that ID is the primary key of the table.
10.	Structure of the Table is shown in the following screenshot:

![ScreenShot1](/Images/ScreenShot1.jpg?raw=true "Optional Title")
 



11.	The following screenshot shows that the repositories from the API are successfully uploaded into the database 

![ScreenShot2](/Images/ScreenShot2.jpg?raw=true "Optional Title") 


The functionality of the application is shown below:

1.	Open http://localhost/Repositories/ in the browser
2.	Click “Add Repositories” to load repositories into the interface as shown below

![ScreenShot3](/Images/ScreenShot3.jpg?raw=true "Optional Title")
 

3.	While uploading the repository details into the database a loading “Please Wait” gif will be displayed as shown below and will be hidden if we click on “OK” alert window as shown in the next screenshot.
 
![ScreenShot4](/Images/ScreenShot4.jpg?raw=true "Optional Title")
 
![ScreenShot5](/Images/ScreenShot5.jpg?raw=true "Optional Title")
4.	Click on small green “+” icon in the first column (as shown in the screenshot below) to view the remaining details of the repository.
![ScreenShot6](/Images/ScreenShot6.jpg?raw=true "Optional Title") 

5.	Click on export buttons “CSV, Excel, PDF” as highlighted in the following screenshot in order to export the data in different formats.

![ScreenShot7](/Images/ScreenShot7.jpg?raw=true "Optional Title") 

6.	Enter any word in the search bar (on top right corner of the screenshot) to filter repositories in the table
![ScreenShot8](/Images/ScreenShot8.jpg?raw=true "Optional Title")
 
7.	Click on each column to sort table using the specific column.

