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
    <title>Client Details</title>
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
    
    $client_query = "SELECT * FROM client WHERE client_id = '$cid'";
    $client_result = $conn->query($client_query);

    if ($client_result && $client_result->num_rows > 0) {
        $client_row = $client_result->fetch_assoc();
        echo "<h2>Client Details</h2>";
        echo "<div class='section'>";
        echo "<h3>Client Information</h3>";
        echo "<p><strong>Client ID:</strong> " . $client_row["Client_Id"] . "</p>";
        echo "<p><strong>Client Name:</strong> " . $client_row["Fname"] . " " . $client_row["Lname"] . "</p>";
        echo "<p><strong>Email:</strong> " . $client_row["Email"] . "</p>";
        echo "<p><strong>Phone:</strong> " . $client_row["Phone_Number"] . "</p>";
        echo "</div>";
    }
    echo "<hr>";

    
    $policy_query = "SELECT * FROM policy WHERE client_id = '$cid'";
    $policy_result = $conn->query($policy_query);

    if ($policy_result && $policy_result->num_rows > 0) {
        echo "<div class='section'>";
        echo "<h3>Policy Details</h3>";
        while ($policy_row = $policy_result->fetch_assoc()) {
            echo "<div>";
            echo "<h4>Policy ID: " . $policy_row["Policy_Id"] . "</h4>";
            echo "<p><strong>Policy Type:</strong> " . $policy_row["Policy_type"] . "</p>";
            echo "<p><strong>Policy Status:</strong> " . $policy_row["Policy_status"] . "</p>";
            echo "<p><strong>Renewal Date:</strong> " . $policy_row["Renewal_Date"] . "</p>";
            echo "<p><strong>Start Date:</strong> " . $policy_row["Start_Date"] . "</p>";
            echo "<p><strong>End Date:</strong> " . $policy_row["End_Date"] . "</p>";
            echo "</div>";
            echo "<hr>";
        }
        echo "</div>";
    } else {
        echo "<div class='section'>";
        echo "<p>No policies found for this client.</p>";
        echo "</div>";
    }
    echo "<hr>";
    
    function getNominees($client_id, $policy_id, $conn) {
        $sql = "SELECT * FROM nominee WHERE client_id = '$client_id' AND policy_id = '$policy_id'";
        $result = $conn->query($sql);
        echo "<div class='section'>";
        echo "<h3>Nominees Details</h3>";
        if ($result && $result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Nominee Number</th><th>Policy ID</th><th>Nominee Name</th><th>Relationship</th></tr>";
            $serialNumber = 1;
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $serialNumber . "</td>";
                echo "<td>" . $policy_id . "</td>";
                echo "<td>" . $row['Nominee_Name'] . "</td>";
                echo "<td>" . $row['Relationship'] . "</td>";
                echo "</tr>";
                $serialNumber++;
            }
            echo "</table>";
        } else {
            echo "<p>No nominees found</p>";
        }
        echo "</div>";
    }

    
    if ($policy_result && $policy_result->num_rows > 0) {
        $policy_result->data_seek(0);
        while ($policy_row = $policy_result->fetch_assoc()) {
            getNominees($cid, $policy_row['Policy_Id'], $conn);
        }
    }

    $conn->close();
    ?>
</div>

</body>
</html>
