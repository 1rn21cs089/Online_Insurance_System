<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['username'])) {
   
    $pid = $_SESSION['pid'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $nomineeNameArray = $_POST["nomineeName"];
    $nomineeAgeArray = $_POST["nomineeAge"];
    $nomineeGenderArray = $_POST["nomineeGender"];
    $relationshipArray = $_POST["relationship"];

    
    function generateUniqueId() {
        $timestamp = time();
        $randomString = bin2hex(random_bytes(3)); 
        $uniqueId = substr("N" . $timestamp . $randomString, 0, 10);  
        return strtoupper($uniqueId);
    }
    $nominee_Id = generateUniqueId();
    $id=$_SESSION['username'];
    
    $stmt = $conn->prepare("INSERT INTO nominee (Nominee_Id, Client_Id, Policy_Id, Nominee_Name, Nominee_Age, Nominee_Gender, Relationship) VALUES (?, ?, ?, ?, ?, ?, ?)");

    
    if ($stmt) {
       
        $stmt->bind_param("sssssss", $nominee_Id, $id, $pid, $nomineeName, $nomineeAge, $nomineeGender, $relationship);

        $success = true; 

        
        foreach ($nomineeNameArray as $key => $nomineeName) {
            $nomineeAge = $nomineeAgeArray[$key];
            $nomineeGender = $nomineeGenderArray[$key];
            $relationship = $relationshipArray[$key];
            $nominee_Id = generateUniqueId();

            
            if (!$stmt->execute()) {
                
                echo "Error inserting nominee data: " . $stmt->error;
                $success = false; 
                break; 
            }
        }

       
        if ($success) {
            
            $_SESSION['nid']=$nominee_Id;
            echo "Nominee details added successfully!";
            header("Location: document.php");
        }
    } else {
        
        echo "Error preparing statement: " . $conn->error;
    }

   
    $stmt->close();
}
} else {
    echo "Please login to continue";
}


$conn->close();

?>
