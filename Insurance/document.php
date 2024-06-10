<?php
session_start();
if(isset($_SESSION['username'])){
    $cid=$_SESSION['username'];
    $pid = $_SESSION['pid'];
    
    $servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$clientInfoQuery = "SELECT * FROM client WHERE Client_Id = ? LIMIT 1";
    $stmt = $conn->prepare($clientInfoQuery);
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $clientInfoResult = $stmt->get_result();
    if (!$clientInfoResult) {
        die("Error in query execution: " . $conn->error);
    }
    if ($clientInfoResult->num_rows > 0) {
        $clientInfoRow = $clientInfoResult->fetch_assoc();
        $fullName = $clientInfoRow['Fname'] . " " . $clientInfoRow['Lname'];
    } else {
        echo "Client information not found for the provided Client ID.";
    }
    $stmt->close();
    
} else {
    echo "Please login to continue";
     header("Location:login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document Upload</title>
<link rel="stylesheet" href="document.css">
</head>
<body>
<div class="container">
  <h2>Upload Documents</h2>
  <form action="doc.php" method="post" enctype="multipart/form-data">
    <h3>Client Details</h3>
    <?php
   
    $client_query = "SELECT * FROM client where Client_Id = '$cid'";
    $client_result = $conn->query($client_query);
    if ($client_result->num_rows > 0) {
        $client_row = $client_result->fetch_assoc();
        echo 'Client ID:<input type="text" name="client_id" placeholder="Client ID" value="' . $client_row["Client_Id"] . '" readonly>';
        
        
        $policy_query = "SELECT * FROM policy WHERE Client_Id='" . $client_row["Client_Id"] . "'";
        $policy_result = $conn->query($policy_query);
        if ($policy_result->num_rows > 0) {
            $policy_row = $policy_result->fetch_assoc();
            echo 'Policy ID:<input type="text" name="policy_id" placeholder="Policy ID" value="' . $policy_row["Policy_Id"] . '" readonly>';
        }
        
        $client_full_name = $client_row["Fname"] . " " . $client_row["Lname"];
        echo 'Client Name:<input type="text" name="client_name" placeholder="Client Name" value="' . $client_full_name . '" readonly>';
    }

    ?>
    Client Photo:<input type="file" name="client_photo" accept=".pdf, .jpeg, .jpg, .png" required>
    Client Aadhar Number:<input type="text" name="client_aadhar_number" placeholder="Client Aadhar Number" required>
    Client Aadhar:<input type="file" name="client_aadhar" accept=".pdf, .jpeg, .jpg, .png" required>
    Client PAN Number:<input type="text" name="client_pan_number" placeholder="Client PAN Number" required>
    Client PAN:<input type="file" name="client_pan" accept=".pdf, .jpeg, .jpg, .png" required>
    <h3>Nominee Details</h3>
    <?php
    
    $nominee_query = "SELECT * FROM nominee where Client_Id = '$cid' AND Policy_Id = '$pid'";
    $nominee_result = $conn->query($nominee_query);
    $nominee_count = 1;
    if ($nominee_result->num_rows > 0) {
        while ($nominee_row = $nominee_result->fetch_assoc()) {
            echo '<div class="nominee_field">';
            echo 'Nominee ' . $nominee_count . ' ID:<input type="text" name="nominee_id[]" placeholder="Nominee ID" value="' . $nominee_row["Nominee_Id"] . '" readonly>';
            echo 'Nominee ' . $nominee_count . ' Name:<input type="text" name="nominee_name[]" placeholder="Nominee Name" value="' . $nominee_row["Nominee_Name"] . '" readonly>';
            echo 'Nominee ' . $nominee_count . ' Photo:<input type="file" name="nominee_photo[]" accept=".pdf, .jpeg, .jpg, .png" required>';
            echo 'Nominee ' . $nominee_count . ' Aadhar Number:<input type="text" name="nominee_aadhar_number[]" placeholder="Nominee Aadhar Number" required>';
            echo 'Nominee ' . $nominee_count . ' Aadhar:<input type="file" name="nominee_aadhar[]" accept=".pdf, .jpeg, .jpg, .png" required>';
            echo 'Nominee ' . $nominee_count . ' PAN Number:<input type="text" name="nominee_pan_number[]" placeholder="Nominee PAN Number" required>';
            echo 'Nominee ' . $nominee_count . ' PAN:<input type="file" name="nominee_pan[]" accept=".pdf, .jpeg, .jpg, .png" required>';
            echo '</div>';
            $nominee_count++;
        }
    }
    ?>
    <button type="submit" name="submit">Submit</button>
  </form>
</div>
</body>
</html>
