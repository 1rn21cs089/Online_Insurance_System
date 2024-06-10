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
    $emailoruserid = $_POST['emailoruserid'];
    $passw = $_POST['passw'];

    
    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ? OR client_id = ? ");
    $stmt->bind_param("ss", $emailoruserid, $emailoruserid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash_passw = $row['Password'];

        
        if (password_verify($passw, $hash_passw)) {
            session_start();
            $_SESSION['username'] = $row['Client_Id'];
            header("Location: home.php");
            exit(); 
        } else {
            echo "<h3>Login failed. Incorrect Password!</h3>";
        }
    } else {
        echo "<h3>Login failed. User Not Found!</h3>";
    }

    $stmt->close();
    $conn->close();
}
?>
