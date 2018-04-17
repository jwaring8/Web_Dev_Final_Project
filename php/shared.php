
<!--
 shared file among all php files. This is where we will put shared functions
 and connection credentials for the database.
-->

<?php
$servername = 'localhost:3306'; // change to your correct localhost port number
$dbname = 'TermProj'; // change to your database name
$username = 'root'; // change to your username
$password = 'root'; // change to your db password 


//connection code

$db = new mysqli($servername, $username, $password, $dbname);

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}           

$query = "SELECT ticker, AVG(close) AS 'average closing price', YEAR(date) AS 'year' 
            FROM sp500_quotes
            WHERE ticker='AMD'
            GROUP BY YEAR(date);";

if(!$result = $db->query($query)){
    die('There was an error running the query [' . $db->error . ']');
}


?>
        


    