<?php
session_start();
if(isset($_SESSION['username'])){
    $cid=$_SESSION['username'];
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
        $sd=$_REQUEST['sd'];
        $age = $_REQUEST['age'];
        $ph=$_REQUEST['ph'];
        $email = $_REQUEST['email'];
        $passw=$_REQUEST['passw'];
        $loc=$_REQUEST['location'];
        $gender = $_REQUEST["gender"];
        $selectedPolicies = $_POST["answers"];
        $policiesString = implode(", ", $selectedPolicies);

function generateUniqueId() {
    $timestamp = time();
    $randomString = bin2hex(random_bytes(3)); 
    $uniqueId = substr("AG" . $timestamp . $randomString, 0, 10);
    return strtoupper($uniqueId);
}
$uniqueId = generateUniqueId();

$hash_passw = password_hash($passw,  
          PASSWORD_DEFAULT); 
 
        


$checkEmailQuery = "SELECT COUNT(*) as count FROM agents WHERE email = '$email'";
$result = mysqli_query($conn, $checkEmailQuery);
$row = mysqli_fetch_assoc($result);
$emailCount = $row['count'];

if ($emailCount == 0) {
    
    $sql = "INSERT INTO agents VALUES ('$uniqueId', default,'$policiesString','$fn', '$ln', '$ph', '$email', '$loc','$gender','$age','$sd','$hash_passw')";

    if (mysqli_query($conn, $sql)) {    
echo '<script>alert("Your Agent Application Process Has Been Initiated"); window.location.href = "home.php";</script>';

    } else {
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }
} else {
    
    echo "<p>Email address already exists. Please use a different email.</p>";
}
$conn->close();
}
}else {
    echo "Please login to continue";
}
?>