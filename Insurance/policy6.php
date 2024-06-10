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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $city = $_POST["city"];
    $state = $_POST["state"];
    $pincode = $_POST["pincode"];
    $insuranceType = $_POST["policyName"];
    $insuranceAmt = $_POST["basicPremium"];
    $age=$_POST["age"];
    
    function generateUniqueId() {
        $timestamp = time();
        $randomString = bin2hex(random_bytes(3)); 
        $uniqueId = substr("R" . $timestamp . $randomString, 0, 10);  
        return strtoupper($uniqueId);
    }
    $PolicyId = generateUniqueId();
    
    
    $startDate = date("Y-m-d H:i:s");
    
    $email = $_POST["email"];
    $clientInfoQuery = "SELECT * FROM client WHERE email='$email' LIMIT 1";
    $clientInfoResult = $conn->query($clientInfoQuery);

    if ($clientInfoResult->num_rows > 0) {
        $clientInfoRow = $clientInfoResult->fetch_assoc();

        $clientId = $clientInfoRow["Client_Id"];

        
        echo "First Name: " . $clientInfoRow["Fname"] . "<br>";
        echo "Last Name: " . $clientInfoRow["Lname"] . "<br>";
        echo "Date of Birth: " . $clientInfoRow["DOB"] . "<br>";
        echo "Phone: " . $clientInfoRow["Phone_Number"] . "<br>";
        echo "E-mail: " . $clientInfoRow["Email"] . "<br>";
        echo "Address: " . $clientInfoRow["Address"] . "<br>";

        date_default_timezone_set('Asia/Kolkata');
        $sd = date("Y-m-d H:i:s");

        date_default_timezone_set('Asia/Kolkata');
        $ed = date("Y-m-d H:i:s", strtotime("+1 year"));

        date_default_timezone_set('Asia/Kolkata');
        $rd = date("Y-m-d H:i:s", strtotime("+1 year"));

        
        $policyQuery = "INSERT INTO policy (Policy_Id, Client_Id, City, State, Pincode, Start_Date, End_Date, Renewal_Date, Agent_Id, Age, Policy_Status, Policy_Type,Policy_Amt)
                VALUES ('$PolicyId', '$clientId', '$city', '$state', '$pincode', '$sd', '$ed', '$rd', Default, $age, Default, '$insuranceType','$insuranceAmt')";



        if ($conn->query($policyQuery) === TRUE) {
            $_SESSION['pid']=$PolicyId;
            echo "Policy added successfully!";
            header("Location: nominees.php");
        } else {
            echo "Error adding policy: " . $conn->error;
        }
    } else {
        echo "Client information not found for the provided email.";
    }

    $conn->close();
}
?>
