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

                            // Calculate age from date of birth
                            $dob = new DateTime($clientInfoRow["DOB"]);
                            $today = new DateTime('today');
                            $age = $dob->diff($today)->y;
                ?>
                

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEALTH POLICY</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('background_image.jpg'); 
            background-size: cover;
        }

        .container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); 
            width: 80%;
            max-width: 600px;
            overflow-y: auto; 
            max-height: 70vh; 
        }

        .health {
            display: flex;
            flex-direction: column;
        }

        .input-box {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="health" action="policy4.php" method="post">
            <h2>Insurance</h2>
            <div class="content">
                
                            <div class="input-box">
                                <label for="id">CLIENT ID</label>
                                <input type="text" name="id" readonly value="<?php echo $_SESSION['username']; ?>">
                            </div>

                            <div class="input-box">
                                <label for="firstName">First Name</label>
                                <input type="text" name="firstName" readonly value="<?php echo $clientInfoRow["Fname"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="lastName">Last Name</label>
                                <input type="text" name="lastName" readonly value="<?php echo $clientInfoRow["Lname"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="dob">Date Of Birth</label>
                                <input type="text" name="dob" readonly value="<?php echo $clientInfoRow["DOB"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="age">Age</label>
                                <input type="text" name="age" readonly value="<?php echo $age; ?>">
                            </div>

                            <div class="input-box">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" readonly value="<?php echo $clientInfoRow["Phone_Number"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="email">E-mail</label>
                                <input type="text" name="email" readonly value="<?php echo $clientInfoRow["Email"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="address">Address</label>
                                <input type="text" name="address" readonly value="<?php echo $clientInfoRow["Address"]; ?>">
                            </div>

                            <div class="input-box">
                                <label for="city">City</label>
                                <input type="text" name="city">
                            </div>

                            <div class="input-box">
                                <label for="state">State</label>
                                <input type="text" name="state">
                            </div>

                            <div class="input-box">
                                <label for="pincode">Pincode</label>
                                <input type="text" name="pincode">
                            </div>

                            <div class="input-box">
                                <label for="policyName">Policy Name</label>
                                <input type="text" name="policyName" readonly value="<?php echo htmlspecialchars($_GET['policyName']); ?>">
                            </div>
                            <div class="input-box">
                                <label for="basicPremium">Basic Premium</label>
                                <input type="text" name="basicPremium" readonly value="<?php echo htmlspecialchars($_GET['basicPremium']); ?>">
                            </div>
                <?php
                        } else {
                            echo "Client information not found for the provided Client ID.";
                        }
                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "Please login to continue";
                    }
                ?>
            </div>
            <a href="nominee.html"><button class="btn btn-danger btn-lg mb-1">Continue</button></a>
        </form>
    </div>
    <hr>
</body>
</html>
