<?php
session_start();
if(isset($_SESSION['username'])){
    $cid=$_SESSION['username'];
    $pid = $_SESSION['pid'];
    $payid = $_SESSION['pay_id'];
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "insurance";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   

    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");

     

    $clientInfoQuery = "SELECT * FROM payment WHERE Payment_Id = ? LIMIT 1";
    $stmt = $conn->prepare($clientInfoQuery);
    $stmt->bind_param("s", $payid);
    $stmt->execute();
    $clientInfoResult = $stmt->get_result();
    if (!$clientInfoResult) {
        die("Error in query execution: " . $conn->error);
    }
    if ($clientInfoResult->num_rows > 0) {
        $clientInfoRow = $clientInfoResult->fetch_assoc();
        
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
<title>Payment Receipt</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 20px;
    }
    .receipt {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto;
    }
    h2 {
        text-align: center;
        color: #333;
    }
    p {
        margin: 10px 0;
        color: #666;
    }
    label {
        font-weight: bold;
    }
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
    .logout-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 5px;
        cursor: pointer;
        border: none;
        margin:20px;
    }
    .logout-button:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>

<div class="receipt">
    <h2>Payment Receipt</h2>
    <p><label>Transaction ID:</label> <?php echo $payid; ?></p>
    <p><label>Client ID:</label> <?php echo $cid; ?></p>
    <p><label>Policy ID:</label> <?php echo $pid; ?></p>
    <p><label>Transaction Date:</label> <?php echo $clientInfoRow['Transaction_Date']; ?></p>
    <p><label>Transaction Mode:</label> <?php echo $clientInfoRow['Transaction_Mode']; ?></p>
    <p><label>Transaction Amount:</label> Rs <?php echo $clientInfoRow['Transaction_Amount']; ?></p>
    <p><label>Time Period:</label> <?php echo $clientInfoRow['Time_Period']; ?></p>
    <p><label>Timestamp (IST):</label> <?php echo $timestamp; ?></p>

    <div class="button-container">
       <button onclick="window.location.href = 'logout.php';" class="logout-button">Logout</button>
       <button onclick="window.location.href = 'home.php';" class="logout-button">Home</button>
    </div>
</div>

</body>
</html>
