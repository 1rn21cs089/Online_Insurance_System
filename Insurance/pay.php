<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "insurance";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_SESSION['username'])) {
    $cid = $_SESSION['username'];
    $pid = $_SESSION['pid'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        function generateUniqueId() {
            $timestamp = time();
            $randomString = bin2hex(random_bytes(3)); 
            $uniqueId = substr("P" . $timestamp . $randomString, 0, 10);
            return strtoupper($uniqueId);
        }
        $payment_id = generateUniqueId();
        
        $transaction_mode = $_POST['tm'];
        $transaction_amount = $_POST['ta'];
        $transaction_date = $_POST['td'];
        $time_period = $_POST['tp'];

       
        $stmt = $conn->prepare("CALL ProcessPayment(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $payment_id, $cid, $pid, $transaction_mode, $transaction_amount, $transaction_date, $time_period);
        $stmt->execute();
        $stmt->close();

        
        $_SESSION['pay_id'] = $payment_id;

        
        header("Location: payment.php");
        exit(); 
    }

    
    $clientInfoQuery = "SELECT * FROM client WHERE Client_Id = ? LIMIT 1";
    $stmt = $conn->prepare($clientInfoQuery);
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $clientInfoResult = $stmt->get_result();
    $clientInfoRow = $clientInfoResult->fetch_assoc();
    $stmt->close();

    
    $policyInfoQuery = "SELECT * FROM policy WHERE Policy_Id = ? LIMIT 1";
    $stmt = $conn->prepare($policyInfoQuery);
    $stmt->bind_param("s", $pid);
    $stmt->execute();
    $policyInfoResult = $stmt->get_result();
    $policyInfoRow = $policyInfoResult->fetch_assoc();
    $stmt->close();
} else {
    echo "Please login to continue";
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
    }

    .container {
        width: 60%;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        
    }
    form{
        margin-left:170px;
    }
    .container:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .container h3 {
        margin-bottom: 20px;
    }

    .inputBox {
        margin-bottom: 15px;
    }

    .inputBox span {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .inputBox input {
        width: 70%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .flex {
        display: flex;
        justify-content: space-between;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    label {
        font-weight: bold;
    }
    .inputBox1 {
        display: flex;
    }

    .inputBox1 input[type="text"] {
        width: 30px; 
        height: 30px; 
        text-align: center;
        margin-right: 5px; 
    }
    .inputBox1 span {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
</head>
<body>
<div class="container">
    <form class="payment" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        
        <div class="row">
            <div class="col">
                <h3 class="title">Billing Address</h3>
                <div class="inputBox">
                    <span>Full Name :</span>
                    <input type="text" placeholder=" " readonly value="<?php echo $clientInfoRow["Fname"]; ?> <?php echo $clientInfoRow["Lname"]; ?>">
                </div>
                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" placeholder=" " readonly value="<?php echo $clientInfoRow["Email"]; ?>" >
                </div>
                <div class="inputBox">
                    <span>Address :</span>
                    <input type="text" placeholder="" readonly value="<?php echo $clientInfoRow["Address"]; ?>">
                </div>
                <div class="inputBox">
                    <span>City :</span>
                    <input type="text" placeholder="" readonly value="<?php echo $policyInfoRow["City"]; ?>">
                </div>
                    <div class="inputBox">
                        <span>State :</span>
                        <input type="text" placeholder="" readonly value="<?php echo $policyInfoRow["State"]; ?>">
                    </div>
                    <div class="inputBox">
                        <span>Zip Code :</span>
                        <input type="text" placeholder="" readonly value="<?php echo $policyInfoRow["Pincode"]; ?>">
                    </div>
            </div>
            <div class="col">
                <h3 class="title">Payment</h3>
                <div class="inputBox">
                    <span>Cards Accepted :</span>
                    <img src="card_img.jpg" alt="">
                </div>
                <div class="inputBox">
                    <span>Name On Card :</span>
                    <input type="text" placeholder="">
                </div>
                <div class="inputBox1">
                    <span>Card Number :</span>
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                    <input type="text" maxlength="1" pattern="[0-9]" placeholder="">
                </div>
                <div class="inputBox">
    <span>Exp Month :</span>
    <select id="expMonthSelect">
        <option value="" selected disabled>Select Month</option>
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
    </select>
</div>

                    <div class="inputBox">
    <span>Exp Year :</span>
    <input type="number" placeholder="" id="expYearInput" oninput="validateYear(this)">
    <span id="errorSpan" style="color: red; display: none;">Year should not be before the current year.</span>
               
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <label>Transaction Mode:</label>
        <input type="radio" name="tm" value="Credit Card" required />Credit Card
        <input type="radio" name="tm" value="Debit Card" required />Debit Card<br /><br />
        <label>Transaction Amount:</label><input type="number" name="ta" value="<?php echo $policyInfoRow["Policy_Amt"]; ?>" required /><br /><br />
        <label>Transaction Date:</label>
        <input type="date" name="td" value="<?php echo date('Y-m-d'); ?>" readonly required /><br /><br />
        <label>Time Period:</label>
        <input type="text" name="tp" id="tp" value="Yearly" readonly><br><br>
        <button type="submit" name="submit" value="Submit">Proceed With Payment</button>
    </form>
</div>
<script>
    function validateYear(input) {
        
        var currentYear = new Date().getFullYear();
        
        
        var year = parseInt(input.value);
        
        
        var errorSpan = document.getElementById("errorSpan");
        
        
        if (year < currentYear) {
            
            errorSpan.style.display = "inline";
        } else {
            
            errorSpan.style.display = "none";
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        var inputs = document.querySelectorAll('.inputBox input[type="text"]');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].addEventListener('input', moveToNextInput);
        }
    });

    function moveToNextInput() {
        var nextInput = this.nextElementSibling;
        if (nextInput != null && this.value.length >= this.maxLength) {
            nextInput.focus();
        }
    }
</script>
</body>
</html>