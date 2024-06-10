<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance";


$conn = new mysqli($servername, 
	$username, $password, $dbname);


if ($conn->connect_error) {
	die("Connection failed: "
		. $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $fn =  $_REQUEST['fn'];
        $ln = $_REQUEST['ln'];
        $dob=$_REQUEST['dob'];
        $adr = $_REQUEST['adr'];
        $ph=$_REQUEST['ph'];
        $email = $_REQUEST['email'];
        $passw=$_REQUEST['passw'];

function generateUniqueId() {
    $timestamp = time();
    $randomString = bin2hex(random_bytes(3)); 
    $uniqueId = substr("CI" . $timestamp . $randomString, 0, 10);
    return strtoupper($uniqueId);
}
$uniqueId = generateUniqueId();

$hash_passw = password_hash($passw,  
          PASSWORD_DEFAULT); 
 
        


$checkEmailQuery = "SELECT COUNT(*) as count FROM client WHERE email = '$email'";
$result = mysqli_query($conn, $checkEmailQuery);
$row = mysqli_fetch_assoc($result);
$emailCount = $row['count'];

if ($emailCount == 0) {
    
    $sql = "INSERT INTO client VALUES ('$uniqueId', '$fn', '$ln', '$dob', '$adr', '$ph', '$email', '$hash_passw', default)";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Your Client Id is $uniqueId'); window.location = 'login.html';</script>";
    } else {
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
} else {
    
    echo "<p>Email address already exists. Please use a different email.</p>";
}


$conn->close();
}

?>