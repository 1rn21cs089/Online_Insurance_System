<?php
session_start();
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

        $cid =  $_REQUEST['cid'];
        $pid = $_REQUEST['pid'];
        $crd=$_REQUEST['crd'];
        $ca=$_REQUEST['ca'];
        $cd=$_REQUEST['crd'];

function generateUniqueId() {
    $timestamp = time();
    $randomString = bin2hex(random_bytes(3)); 
    $uniqueId = substr("CL" . $timestamp . $randomString, 0, 10);
    return strtoupper($uniqueId);
}
$uniqueId = generateUniqueId();

 
        


    $sql = "INSERT INTO claims VALUES ('$uniqueId', '$cid', default, '$ca',default,'$cd')";

    if (mysqli_query($conn, $sql)) {
        echo "<h3>(Data stored in the database successfully).";
    } else {
        echo "ERROR: Hush! Sorry $sql. " . mysqli_error($conn);
    }


$conn->close();
}

?>