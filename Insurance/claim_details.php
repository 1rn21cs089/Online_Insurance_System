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
} else {
    echo "Please login to continue";
    header("Location:login.html");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policy Details</title>
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            margin-top: 0;
            text-align:center;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    
    $policy_id = $_POST['policy_id'];

    $policy_query = "SELECT * FROM policy WHERE policy_id = '$policy_id'";

    $policy_result = $conn->query($policy_query);
    

    if ( $policy_result && $policy_result->num_rows > 0) {
        $policy_row = $policy_result->fetch_assoc();
        echo "<h2>Policy Details</h2>";
        echo "<div class='section'>";
        echo "<h3>Policy Information</h3>";
        echo "<p><strong>Policy ID:</strong> " . $policy_row["Policy_Id"] . "</p>";
        echo "<p><strong>Policy Type:</strong> " . $policy_row["Policy_type"] . "</p>";
        echo "<p><strong>Policy Status:</strong> " . $policy_row["Policy_status"] . "</p>";
        echo "<p><strong>Renewal Date:</strong> " . $policy_row["Renewal_Date"] . "</p>";
        echo "<p><strong>Start Date:</strong> " . $policy_row["Start_Date"] . "</p>";
        echo "<p><strong>End Date:</strong> " . $policy_row["End_Date"] . "</p>";
        echo "</div>";
    }
    echo "<hr>";

    

    
    $claim_query = "SELECT * FROM claims WHERE policy_id = '$policy_id' ";
    $claim_result = $conn->query($claim_query);

     echo "<div class='section'>";
     echo "<h3>Claim History</h3>";

    if ($claim_result && $claim_result->num_rows > 0) {
       
        while ($claim_row = $claim_result->fetch_assoc()) {
            echo "<p><strong>Claim ID:</strong> " . $claim_row["Claim_Id"] . "</p>";
            echo "<p><strong>Date:</strong> " . $claim_row["Claim_Date"] . "</p>";
            echo "<p><strong>Status:</strong> " . $claim_row["Claim_Status"] . "</p>";
            echo "<p><strong>Amount:</strong> " . $claim_row["Claim_Amt"] . "</p>";
        }     
    }
 else {
    echo "<div class='section'>";
    echo "No claims have been claimed for the policy.";
    echo "</div>";
}


echo "<script>";
echo "function redirectNo() {";
echo "  window.location.href = 'claims.php';";
echo "}";
echo "</script>";


    
    ?>
</div>
<hr>
<?php
function getNominees($client_id,$policy_id, $conn) {
        $sql = "SELECT * FROM nominee WHERE client_id = '$client_id' AND policy_id = '$policy_id' ";
        $result = $conn->query($sql);
        echo "<h3>Nominees Details</h3>";
        if ($result->num_rows > 0) {
            echo "<table>";
           echo "<tr><th>Nominee Number</th><th>Nominee Name</th><th>Relationship</th></tr>";
            $serialNumber = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $serialNumber . "</td>";
                echo "<td>" . $row['Nominee_Name'] . "</td>";
                echo "<td>" . $row['Relationship'] . "</td>";
                echo "</tr>";
                $serialNumber++;
            }
            echo "</table>";
            
        } else {
            echo "<p>No nominees found</p>";
        }
    }
    getNominees($cid,$policy_id, $conn);
    $conn->close();
     ?>
     <hr>
     <form action="request_claim.php" method="post">
    <input type="hidden" name="policy_id" value="<?php echo $policy_id; ?>">
    <div>
        <label for="claim_amount">Claim Amount:</label>
        <input type="text" id="claim_amount" name="claim_amount" required>
    </div>
    <?php
    
    if ($policy_row["Policy_status"] === "REQUEST FOR WITHDRAWAL") {
        
        echo "<script>";
        echo "alert('This policy cannot be claimed as it is in REQUEST FOR WITHDRAWAL status.');";
        echo "window.location.href = 'claims.php';";
        echo "</script>";
    } else {
        
        echo "<p>Do you want to claim this policy?</p>";
        echo "<button type='submit' name='confirm_claim' value='true'>Yes</button>";
        echo "<button type='button' onclick='redirectNo()'>No</button>";
    }
    ?>
</form>
</body>
</html>