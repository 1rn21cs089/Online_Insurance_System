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
    <title>Terms and Conditions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 80%;
            max-height: 80%;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        h3 {
            color: #333;
            margin-top: 15px;
        }

        ul {
            margin-bottom: 20px;
        }

        .buttons {
            margin-top: 30px;
            text-align: center;
        }

        .buttons .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }

        .red-btn {
            background-color: #f44336;
            color: white;
        }

        .gray-btn {
            background-color: #ccc;
            color: #333;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Terms and Conditions</h2>

        <p>Welcome to our Life Insurance website. By continuing to browse and use this website, you agree to comply with and be bound by the following terms and conditions of use, which, together with our privacy policy, govern our relationship with you concerning this website. If you do not agree with any part of these terms and conditions, please refrain from using our website.</p>

<h3>1. Use of Content:</h3>
<ul>
    <li>The content provided on this website is for general informational purposes only. It may change without prior notice.</li>
    <li>Your use of any information or materials on this website is entirely at your own risk. We shall not be liable for any consequences arising from such use. It is your responsibility to ensure that any life insurance products or information obtained from this website meet your specific requirements.</li>
</ul>

<h3>2. Privacy Policy:</h3>
<p>Your use of this website is also governed by our Privacy Policy. Please review our Privacy Policy, as it forms an integral part of these terms and conditions, to understand our data handling practices.</p>

<h3>3. Changes to Terms and Conditions:</h3>
<p>We reserve the right to revise these terms and conditions at any time without prior notice. Your continued use of this website constitutes acceptance of the then-current version of these terms and conditions.</p>

        <div class="buttons">
            <a href="form2.php?policyName=<?php echo urlencode($_GET['policyName']); ?>&basicPremium=<?php echo urlencode($_GET['basicPremium']); ?>"><button class="btn red-btn">ACCEPT</button></a>
            <a href="home.html"><button class="btn gray-btn">DECLINE</button></a>
    </div>
    </div>
</body>
</html>
