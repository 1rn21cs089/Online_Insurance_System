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
  <title>Health Policy Purchase</title>
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
    <h1>Understanding Health Policy</h1>
    <p>Health policy plays a crucial role in ensuring access to quality healthcare services for everyone. It involves decision-making, planning, and implementation of various strategies to improve public health and healthcare systems.</p>

    <h2>Importance of Health Policy</h2>
    <p>Health policy addresses issues such as healthcare financing, insurance coverage, healthcare delivery, public health interventions, and regulatory frameworks. It aims to promote health equity, improve health outcomes, and ensure the availability of essential healthcare services.</p>

    <h2>Available Health Policies</h2>
    <table>
        <tr>
            <th>Policy Name</th>
            <th>Policy Tenure</th>
            <th>Sum Insured</th>
            <th>Basic Premium</th>
            <th>Premium Payment Mode</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>Basic Health Plan</td>
            <td>10 year</td>
            <td>₹5,00,000</td>
            <td>₹10,000</td>
            <td>Yearly</td>
            <td><button onclick="purchasePolicy('Basic Health Plan', '10000')">Purchase</button></td>
        </tr>
        <tr>
            <td>Comprehensive Health Plan</td>
            <td>10 year</td>
            <td>₹1,00,000</td>
            <td>₹20,000</td>
            <td>Yearly</td>
            <td><button onclick="purchasePolicy('Comprehensive Health Plan', '20000')">Purchase</button></td>
        </tr>
    </table>
</div>

<script>
    function purchasePolicy(policyName, basicPremium) {
        
        alert("You have purchased " + policyName);

        
        window.location.href = "terms_condition1.php?policyName=" + encodeURIComponent(policyName) + "&basicPremium=" + encodeURIComponent(basicPremium);
    }
</script>
</body>
</html>
