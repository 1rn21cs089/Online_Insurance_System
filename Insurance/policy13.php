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
  <title>Home Insurance Policy Purchase</title>
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
    <h1>Understanding Home Insurance</h1>
    <p>Home insurance is a type of property insurance that covers losses and damages to an individual's residence, along with furnishings and other assets in the home. It provides financial protection against risks such as fire, theft, vandalism, natural disasters, and liability.</p>

    <h2>Importance of Home Insurance</h2>
    <p>Home insurance is essential to protect one of your most significant investments - your home. It not only provides coverage for repairing or rebuilding your home but also helps replace personal belongings and offers liability protection in case someone is injured on your property.</p>

    <h2>Available Home Insurance Policies</h2>
    <table>
      <tr>
        <th>Policy Name</th>
        <th>Policy Tenure</th>
        <th>Sum Assured</th>
        <th>Basic Premium</th>
        <th>Payment Time Period</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>Home Shield</td>
        <td>10 years</td>
        <td>Rs 1 crore + Rs 35 L</td>
        <td>Rs  1,55,966</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Home Shield','155966')">Purchase</button></td>
      </tr>
      <tr>
        <td>Griha Suvidha</td>
        <td>7 years</td>
        <td>Rs 50 L + Rs 15 L</td>
        <td>Rs  1,26,538</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Griha Suvidha','126538')">Purchase</button></td>
      </tr>
      <tr>
        <td>Home Insurance Plan</td>
        <td>10 years</td>
        <td>Rs 1 crore + Rs 10 L</td>
        <td>Rs 87,696</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Home Insurance Plan','87696')">Purchase</button></td>
      </tr>
    </table>
  </div>

  <script>
    function purchasePolicy(policyName, basicPremium) {
      alert("You have purchased " + policyName);
      
      window.location.href = "terms_condition3.php?policyName=" + encodeURIComponent(policyName)+ "&basicPremium=" + encodeURIComponent(basicPremium);

    }
  </script>
</body>
</html>
