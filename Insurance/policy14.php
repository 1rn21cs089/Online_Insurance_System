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
  <title>Motor Insurance Policy Purchase</title>
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
    <h1>Understanding Motor Insurance</h1>
    <p>Motor insurance provides financial protection against physical damage or bodily injury resulting from traffic collisions and against liability that could also arise from incidents in a vehicle. It covers both the vehicle and third-party liability.</p>

    <h2>Importance of Motor Insurance</h2>
    <p>Motor insurance is essential as it not only protects the vehicle owner against financial losses due to damage or theft of the vehicle but also covers medical expenses in case of injuries to the driver and passengers, as well as liability claims arising from third-party damages.</p>

    <h2>Available Motor Insurance Policies</h2>
    <table>
      <tr>
        <th>Policy Name</th>
        <th>Premium Amount</th>
        <th>Period of Coverage</th>
        <th>Payment Time Period</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>Basic Liability</td>
        <td>Rs 30,000</td>
        <td>12-Month</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Basic Liability','30000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Comprehensive Liability</td>
        <td>Rs 48,000</td>
        <td>12-Month</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Comprehensive Liability','48000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Third Party Only</td>
        <td>Rs 38,400</td>
        <td>12-Month</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Third Party Only','38400')">Purchase</button></td>
      </tr>
      <tr>
        <td>Personal Accident Cover</td>
        <td>Rs 3600</td>
        <td>12-Month</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Personal Accident Cover','3600')">Purchase</button></td>
      </tr>
    </table>
  </div>

  <script>
    function purchasePolicy(policyName, basicPremium) {
      alert("You have purchased " + policyName);
      
      window.location.href = "terms_condition4.php?policyName=" + encodeURIComponent(policyName)+ "&basicPremium=" + encodeURIComponent(basicPremium);

    }
  </script>
</body>
</html>
