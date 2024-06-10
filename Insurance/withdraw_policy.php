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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Policies</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: black;
            color:white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<?php
// Establish a connection to the database

// Prepare and bind the SQL statement
$stmt = $conn->prepare("SELECT policy_id, policy_type, policy_status, renewal_date, start_date, end_date FROM policy WHERE client_id = ?");
if (!$stmt) {
    die("Error in preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $cid);

// Execute the query
$stmt->execute();

// Bind result variables
$stmt->bind_result($policy_id, $policy_type, $policy_status, $renewal_date, $start_date, $end_date);

$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<center><h2>Your Policies</h2></center>";
    echo "<table>";
    echo "<tr><th>Policy ID</th><th>Policy Type</th><th>Policy Status</th><th>Renewal Date</th><th>Start Date</th><th>End Date</th><th>Details</th></tr>";
    while($stmt->fetch()) {
        echo "<tr>";
        echo "<td>".$policy_id."</td>";
        echo "<td>".$policy_type."</td>";
        echo "<td>".$policy_status."</td>";
        echo "<td>".$renewal_date."</td>";
        echo "<td>".$start_date."</td>";
        echo "<td>".$end_date."</td>";
        echo "<td><form action='policy_details.php' method='post'><input type='hidden' name='policy_id' value='".$policy_id."'><button type='submit'> View Details</button></form></td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='home.php'><button class='proceed-btn'>Return</button></a>";
} else {
    echo "No policies found for this client.";
}
    
// Close statement and connection
$stmt->close();
$conn->close();
?>

</body>
</html>