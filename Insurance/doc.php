<?php
session_start();
if(isset($_SESSION['username'])){
    $cid=$_SESSION['username'];
    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$client_id = $_POST['client_id'];


$policy_query = "SELECT * FROM policy WHERE Client_Id='$client_id'";
$policy_result = $conn->query($policy_query);
if ($policy_result->num_rows > 0) {
    $policy_row = $policy_result->fetch_assoc();
    $policy_id = $policy_row["Policy_Id"];
}
function generateUniqueId() {
    $timestamp = time();
    $randomString = bin2hex(random_bytes(3)); 
    $uniqueId = substr("D" . $timestamp . $randomString, 0, 10);  
    return strtoupper($uniqueId);
}
$document_Id = generateUniqueId();
echo $document_Id;
$client_photo = $_FILES["client_photo"]["tmp_name"];
    $client_aadhar_number = $_POST["client_aadhar_number"];
    $client_aadhar = $_FILES["client_aadhar"]["tmp_name"];
    $client_pan_number = $_POST["client_pan_number"];
    $client_pan = $_FILES["client_pan"]["tmp_name"];

for ($i = 0; $i < count($_POST['nominee_id']); $i++) {
    $nominee_id = $_POST['nominee_id'][$i];

    
    $nominee_query = "SELECT * FROM nominee WHERE Nominee_Id='$nominee_id' AND Policy_Id = '$policy_id'";
    $nominee_result = $conn->query($nominee_query);
    if ($nominee_result->num_rows > 0) {
        $nominee_row = $nominee_result->fetch_assoc();
    }

    
    $nominee_photo = $_FILES["nominee_photo"]["tmp_name"][$i];
    $nominee_aadhar_number = $_POST["nominee_aadhar_number"][$i];
    $nominee_aadhar = $_FILES["nominee_aadhar"]["tmp_name"][$i];
    $nominee_pan_number = $_POST["nominee_pan_number"][$i];
    $nominee_pan = $_FILES["nominee_pan"]["tmp_name"][$i];

    $nominee_insert_sql = "INSERT INTO document VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?)";
    $nominee_stmt = $conn->prepare($nominee_insert_sql);
    $nominee_stmt->bind_param("ssssssssssssss",$document_Id,  $client_id, $policy_id, $client_photo, $client_aadhar_number, $client_aadhar, $client_pan_number, $client_pan, $nominee_id, $nominee_photo, $nominee_aadhar_number, $nominee_aadhar, $nominee_pan_number, $nominee_pan);
    $nominee_stmt->execute();
    $nominee_stmt->close();
}

$conn->close();


header("Location: pay.php");
exit();

} else {
    echo "Please login to continue";
     header("Location:login.html");
}
?>
