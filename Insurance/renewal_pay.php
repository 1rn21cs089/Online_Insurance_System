<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Renewal Payment</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>Renewal Payment</h2>
    <?php
    session_start();

    
    if(isset($_SESSION['username'])){
        $cid = $_SESSION['username'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "insurance";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $policiesQuery = "SELECT p.*, n.Nominee_Name FROM policy p INNER JOIN nominee n ON p.Policy_Id = n.Policy_Id WHERE p.Client_Id = ?";
        $stmt = $conn->prepare($policiesQuery);
        $stmt->bind_param("s", $cid);
        $stmt->execute();
        $policiesResult = $stmt->get_result();

       
        if ($policiesResult->num_rows > 0) {
            
            while($policyRow = $policiesResult->fetch_assoc()) {
                
                $amountToBePaid = $policyRow['Policy_Amt'] * 1.02;

                
                echo "<div class='policy-box'>";
                echo "<h3>Policy Type: " . $policyRow['Policy_type'] . "</h3>";
                echo "<p>Policy Amount: Rs " . $policyRow['Policy_Amt'] . "</p>";
                echo "<p>Nominee Name: " . $policyRow['Nominee_Name'] . "</p>";
                echo "<p>Renewal Date: " . $policyRow['Renewal_Date'] . "</p>";
                echo "<p>Amount to be Paid: Rs " . number_format($amountToBePaid, 2) . "</p>";
                echo "<button onclick='pay(\"{$policyRow['Renewal_Date']}\", {$amountToBePaid})'>Pay</button>";
                echo "</div>";
            }
        } else {
            echo "No policies found for the current user.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please login to continue";
    }
    ?>
</div>

<script>
function pay(renewalDate, paymentAmt) {
    var currentDate = new Date();
    var renewDate = new Date(renewalDate);
    
    if (currentDate.getTime() < renewDate.getTime()) {
        alert("Payment can only be done on or after the renewal date.");
        window.location.href = 'home.php'; 
        return;
    }

    alert("Payment amount: Rs " + paymentAmt.toFixed(2));
    
}
</script>


</body>
</html>
