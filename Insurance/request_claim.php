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
    header("Location: login.html");
    exit(); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["confirm_claim"]) && $_POST["confirm_claim"] == "true") {
        
        $claim_amount = $_POST['claim_amount'];
        $policy_id = $_POST['policy_id'];

        
        $claim_id = uniqid('CLAIM');

        
        $claim_status = "Pending"; 
        $claim_date = date('Y-m-d'); 

        
        $sql = "INSERT INTO claims (Claim_Id, Client_Id, Policy_Id, Claim_Amt, Claim_Status, Claim_Date) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing statement: " . $conn->error;
            exit;
        }

        
        $stmt->bind_param("ssssss", $claim_id, $cid, $policy_id, $claim_amount, $claim_status, $claim_date);

        
        $stmt->execute();

        
        if ($stmt->errno) {
            echo "Error inserting record: " . $stmt->error;
        } else {
           
            header("Location: claims.php");
            exit;
        }

        
        $stmt->close();
    }

    
    if (isset($_POST["confirm_claim_request"]) && $_POST["confirm_claim_request"] == "true") {
        
        header("Location: claims.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Policy Review</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2, h3 {
        color: #333;
        text-align: center;
    }
    p {
        line-height: 1.6;
        color: #666;
    }
    .highlight {
        background-color: #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .btn {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Policy Review</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2, h3 {
        color: #333;
        text-align: center;
    }
    p {
        line-height: 1.6;
        color: #666;
    }
    .highlight {
        background-color: #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .btn {
        display: inline-block;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Policy Withdrawal Terms and Conditions</h2>
<p>
    Withdrawal Procedure: The policyholder may request the withdrawal of the policy by submitting a formal written request to the provider. The request must include the policy number, effective date, and reasons for withdrawal.
</p>
<p>
    Notification Period: The policyholder must provide a minimum notification period of [insert number] days prior to the intended withdrawal date.
</p>
<p>
    Withdrawal Charges: A withdrawal fee may be applicable upon the termination of the policy. The amount of the withdrawal fee is determined by the provider and is subject to change without prior notice.
</p>
<p>
    Refund Policy: Upon withdrawal of the policy, the policyholder may be entitled to a refund of premiums paid, subject to deductions for any applicable withdrawal charges and outstanding fees.
</p>
<p>
    Effective Date: The withdrawal of the policy shall take effect on the date specified by the provider, typically following the completion of all necessary administrative procedures and settlement of any outstanding obligations.
</p>
<p>
    Policyholder Obligations: The policyholder is responsible for fulfilling any outstanding obligations, such as payment of premiums or settlement of claims, prior to the withdrawal of the policy.
</p>
<p>
    Termination of Coverage: Upon withdrawal of the policy, coverage under the policy shall cease, and the policyholder shall no longer be entitled to any benefits, services, or protections provided by the policy.
</p>
<p>
    Policyholder Rights: The policyholder reserves the right to withdraw the policy at any time, subject to the terms and conditions outlined herein and in accordance with applicable laws and regulations.
</p>
<p>
    Provider's Discretion: The provider reserves the right to refuse or delay the withdrawal of the policy under certain circumstances, including but not limited to pending claims, outstanding debts, or suspected fraudulent activity.
</p>
<p>
    Amendment of Terms: These terms and conditions are subject to change at the discretion of the provider. Any amendments to these terms shall be communicated to the policyholder in writing.
</p>
<p>If you wish to request a claim for this policy, please click the button below:</p>
    <button class="btn" onclick="requestClaim()">Request Claim</button>

</div>


<script>
    function requestClaim() {
        
        var confirmation = confirm("Are you sure you want to request a claim for this policy?");
        if (confirmation) {
           
            var form = document.createElement("form");
            form.method = "POST";
            
            form.action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
            
            
            var input = document.createElement("input");
            input.type = "hidden";
            input.name = "confirm_claim_request";
            input.value = "true";
            form.appendChild(input);
            
            
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

</body>
</html>
