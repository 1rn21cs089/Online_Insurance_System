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
  <title>Retirement Insurance Policy Purchase</title>
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
    <h1>Understanding Retirement Insurance</h1>
    <p>Retirement insurance, also known as pension insurance, is a type of insurance policy that provides financial security and income replacement during retirement. It ensures that individuals have enough funds to maintain their lifestyle and cover expenses after retirement.</p>

    <h2>Importance of Retirement Insurance</h2>
    <p>Retirement insurance helps individuals plan for a financially secure retirement by building a retirement corpus through regular contributions or lump-sum investments. It offers peace of mind by providing guaranteed income streams, annuities, or lump-sum payouts during retirement.</p>

    <h2>Available Retirement Insurance Policies</h2>
    <table>
      <tr>
        <th>Policy Name</th>
        <th>Time Period</th>
        <th>Sum Assured</th>
        <th>Premium Amount</th>
        <th>Payment Time Period</th>
        <th>Action</th>
      </tr>
      <tr>
        <td>Deferred Annuity Plan</td>
        <td>20 years</td>
        <td>Rs 1 Crore + Rs 25 Lakh</td>
        <td>₹50,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Deferred Annuity Plan','50000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Immediate Annuity Plan</td>
        <td>Lifetime</td>
        <td>Rs 1 Crore + Rs 15 Lakh</td>
        <td>₹12,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Immediate Annuity Plan','12000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Retirement Savings Plan</td>
        <td>25 years</td>
        <td>Rs 2 Crore</td>
        <td>₹80,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Retirement Savings Plan','80000')">Purchase</button></td>
      </tr>
      <tr>
        <td>Retirement Income Plan</td>
        <td>15 years</td>
        <td>Rs 1 Crore + Rs 5 Lakh</td>
        <td>₹72,000</td>
        <td>Yearly</td>
        <td><button onclick="purchasePolicy('Retirement Income Plan','72000')">Purchase</button></td>
      </tr>
    </table>
  </div>

  <script>
    function purchasePolicy(policyName, basicPremium) {
      alert("You have purchased " + policyName);
      window.location.href = "terms_condition6.php?policyName=" + encodeURIComponent(policyName)+ "&basicPremium=" + encodeURIComponent(basicPremium);

    }
  </script>
</body>
</html>     