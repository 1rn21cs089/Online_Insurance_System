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
    $conn->close();
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
  <title>General Insurance Policy Purchase</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f4;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      padding: 0 20px;
    }

    h1, h2 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    button {
      padding: 8px 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Understanding General Insurance</h1>
    <p>General insurance is a type of insurance policy that provides financial protection for non-life assets such as property, vehicles, health, travel, and liability. It covers risks and losses arising from unforeseen events and accidents.</p>

    <h2>Importance of General Insurance</h2>
    <p>General insurance offers peace of mind by safeguarding your valuable assets and providing coverage against various risks. Whether it's protecting your home from fire damage, your vehicle from accidents, or your health during travel, general insurance ensures you are financially protected.</p>

    <h2>Available General Insurance Policies</h2>
    <table>
      <tr>
        <th>Policy Name</th>
        <th>Time Period</th>
        <th>Investment Amount (INR)</th>
        <th>Payment Time Period</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>Home Insurance</td>
        <td>1 year</td>
        <td>₹50,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Home Insurance','50000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Vehicle Insurance</td>
        <td>1 year</td>
        <td>₹20,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Vehicle Insurance','20000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Travel Insurance</td>
        <td>1 month</td>
        <td>₹60,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Travel Insurance','60000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Health Insurance</td>
        <td>1 year</td>
        <td>₹30,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Health Insurance','30000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Liability Insurance</td>
        <td>1 year</td>
        <td>₹40,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Liability Insurance','40000')">Purchase</button></td>
      </tr>
    </table>
  </div>

  <script>
    function purchasePolicy(policyName, basicPremium) {
      alert("You have purchased " + policyName);
      
      window.location.href = "terms_condition5.php?policyName=" + encodeURIComponent(policyName)+ "&basicPremium=" + encodeURIComponent(basicPremium);

    }
  </script>
</body>
</html>
