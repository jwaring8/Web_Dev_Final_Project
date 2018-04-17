<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    

<?php
$servername = "";
$username = "root";
$password = "root";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT TICKER FROM DB_NAME WHERE DATE = '";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "SSN: " . $row["ssn"]. " Name: " . $row["first_name"]. " " . $row["last_name"]. " E-mail: " .$row["email"] . " Gender: " . $row["gender"] . " Credit Card Number: " . $row["cc_number"] . " Bank: " . $row["cc_vendor"] . "<br>";
    }
} else {
    echo "Sorry. This action could not be completed.";
}
$conn->close();
?>
    
    
<?php
$servername = "";
$username = "root";
$password = "root";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


GET YEAR: STORE IN VAR +1 TO YEAR.
$sql = "SELECT TICKER FROM DB_NAME WHERE DATE = '";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "SSN: " . $row["ssn"]. " Name: " . $row["first_name"]. " " . $row["last_name"]. " E-mail: " .$row["email"] . " Gender: " . $row["gender"] . " Credit Card Number: " . $row["cc_number"] . " Bank: " . $row["cc_vendor"] . "<br>";
    }
} else {
    echo "Sorry. This action could not be completed.";
}
$conn->close();
       
    
$mv_avg = $start - $stop; 
    
    if($mv_avg > 1){
    echo "This stock volume has a positive moving average which is an indicator that the company is doing well and growing.";
    }
    else if($mv_avg == 0){
        echo "This stock volume has not increased or decreased.";
    }
    else{
        echo "This stock volume has a decreasing moving average which is a negative indicator.";
    }
?> 
    
</body>
</html>
