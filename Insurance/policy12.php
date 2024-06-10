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
  <title>Life Insurance Policy Purchase</title>
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
    <h1>Understanding Life Insurance Policy</h1>
    <p>Life insurance is a contract between an insurer and a policyholder, where the insurer guarantees payment of a death benefit to named beneficiaries upon the death of the insured person. It provides financial protection to the family and dependents of the insured in case of their untimely demise.</p>

    <h2>Importance of Life Insurance Policy</h2>
    <p>Life insurance helps ensure that your loved ones are financially secure and can maintain their standard of living even after your death. It can cover various expenses such as funeral costs, mortgage payments, children's education, and daily living expenses.</p>

    <h2>Available Life Insurance Policies</h2>
    <table>
        <tr>
            <th>Policy Name</th>
            <th>Premium Payment Term</th>
            <th>Premium Term</th>
            <th>Premium Amount</th>
            <th>Payment Mode</th>
            <th>Payment Amount/Mode</th>
            <th>Action</th>
        </tr>
        <tr>
            <td>Term Life Insurance</td>
            <td>10 years</td>
            <td>85 years</td>
            <td>₹1,00,00,000</td>
            <td>Yearly</td>
            <td>₹5,000</td>
            <td><button onclick="purchasePolicy('Term Life Insurance', '5000')">Purchase</button></td>
        </tr>
        <tr>
            <td>Term Life Insurance</td>
            <td>12 years</td>
            <td>85 years</td>
            <td>₹2,00,00,000</td>
            <td>Yearly</td>
            <td>₹7,500</td>
            <td><button onclick="purchasePolicy('Term Life Insurance', '7500')">Purchase</button></td>
        </tr>
    </table>
</div>

<script>
    function purchasePolicy(policyName, basicPremium) {
        alert("You have purchased " + policyName);
        
        window.location.href = "terms_condition2.php?policyName=" + encodeURIComponent(policyName) + "&basicPremium=" + encodeURIComponent(basicPremium);
    }
</script>
</body>
</html>
