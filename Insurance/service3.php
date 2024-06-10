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
}$clientInfoQuery = "SELECT * FROM client WHERE Client_Id = ? LIMIT 1";
    $stmt = $conn->prepare($clientInfoQuery);
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $clientInfoResult = $stmt->get_result();
    if (!$clientInfoResult) {
        die("Error in query execution: " . $conn->error);
    }
    if ($clientInfoResult->num_rows > 0) {
        $clientInfoRow = $clientInfoResult->fetch_assoc();
    } else {
        echo "Client information not found for the provided Client ID.";
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Please login to continue";
}
?>
<html>
<head>
    <title>Agents</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
          integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk"
          crossorigin="anonymous">
    <script src="captcha.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input-box {
            margin-bottom: 20px;
        }

        .input-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-box input[type="text"],
        .input-box input[type="date"],
        .input-box input[type="password"],
        .input-box input[type="email"] {
            width: calc(100% - 10px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-box input[type="radio"] {
            margin-right: 10px;
        }

        .terms {
            display: none;
            margin-top: 20px;
        }

        .terms h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 10px;
        }

        .terms h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .terms p {
            line-height: 1.6;
            margin-bottom: 20px;
        }

        #showTermsBtn {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        #accept_terms {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body onload="generate()">


    <h2>Agent Information Form</h2>

    <div class="form-container">
    <form action="agent.php" method="post">
         <div class="input-box">
                    <label for="name">First Name</label>
                    <input type="text" placeholder=" " name="fn" readonly value="<?php echo $clientInfoRow["Fname"]; ?>">
                </div>
                <div class="input-box">
                    <label for="name">Last Name</label>
                    <input type="text" placeholder=" " name="ln" readonly value="<?php echo $clientInfoRow["Lname"]; ?>">
                </div>
                <div class="input-box">
                    <label for="name">Date Of Birth</label>
                    <input type="text" placeholder=" " name="dob" readonly value="<?php echo $clientInfoRow["DOB"]; ?>">
                </div>
                <div class="input-box">
                    <label for="name">Age</label>
                    <input type="text" placeholder=" " name="age">
                </div>
                <div class="input-box">
                    <label for="name">Phone</label>
                    <input type="text" placeholder=" " name="ph" readonly value="<?php echo $clientInfoRow["Phone_Number"]; ?>">
                </div>
                 <div class="input-box">
                    <label for="name">E-mail</label>
                    <input type="text" placeholder=" " name="email" readonly value="<?php echo $clientInfoRow["Email"]; ?>">
                </div>
                <div class="input-box">
                    <label for="location">Address</label>
                    <input type="text" placeholder=" " name="location" readonly value="<?php echo $clientInfoRow["Address"]; ?>">
                </div>
<div class="input-box">
        <label for="gender">Gender:</label>
        <input type="radio" id="gender" name="gender" value="male" required />Male

        <input type="radio" id="gender" name="gender" value="female">Female
        <input type="radio" id="gender" name="gender" value="other">Other
        </div>
        <br><br />

        <div class="input-box">
        <label for="option3">Start Date</label>
        <input type="date" name="sd" required><br><br />
        </div>
        <label>Policies Handled:</label>
        <input type="checkbox" id="option1" name="answers[]" value="Health" required>
        <label for="option1">Health</label>


        <input type="checkbox" id="option2" name="answers[]" value="Life">
        <label for="option2">Life</label>


        <input type="checkbox" id="option3" name="answers[]" value="Home">
        <label for="option3">Home</label>


        <input type="checkbox" id="option3" name="answers[]" value="Motor">
        <label for="option3">Motor</label>


        <input type="checkbox" id="option3" name="answers[]" value="General">
        <label for="option3">General</label>


        <input type="checkbox" id="option3" name="answers[]" value="Retirement">
        <label for="option3">Retirement</label>
        
        <br><br />
        <div class="input-box">
        <label>Password: <input type="password" required name="passw" id="password" /></label><br /><br />
        <label>Confirm Password: <input type="password" id="confirm_password" required onblur="validate()" /></label><br /><br />
        </div>
        <label>Captcha Code:</label><br />
        <div id="image"
             selectable="False">
        </div>
        <div onclick="generate()">

            <i class="fas fa-sync"></i>
        </div>
        <div id="user-input">
            <input type="text"
                   id="submit"
                   placeholder="Enter Captcha:" required />
        </div><br />
        <input type="submit"
               id="btn"
               onclick="printmsg(event)" />

        <p id="key"></p>
        <button id="showTermsBtn" onclick="showTerms()">View Terms and Conditions</button>
        <div class="terms" id="terms">
            <h1>Agent Terms and Conditions</h1>
            <h2>1. Responsibilities</h2>
            <p>
                As an agent of our company, you agree to fulfill the following responsibilities:
                <ul>
                    <li>Provide accurate information to clients about our products and services.</li>
                    <li>Assist clients in selecting the most suitable insurance policies based on their needs.</li>
                    <li>Handle client inquiries and resolve issues promptly and professionally.</li>
                    <li>Maintain confidentiality of client information.</li>
                </ul>
            </p>

            <h2>2. Commission Structure</h2>
            <p>
                You will be compensated based on the commission structure outlined in your agent agreement. Commission rates may vary depending on the type of policy sold and other factors. Please refer to your agent agreement for detailed information on commission rates and payment terms.
            </p>

            <h2>3. Non-Compete Agreement</h2>
            <p>
                During your tenure as an agent with our company and for a specified period after termination of your contract, you agree not to engage in any activities that directly compete with our business. This includes soliciting clients or employees, or promoting competing products or services.
            </p>

            <h2>4. Termination</h2>
            <p>
                Your contract as an agent may be terminated by either party with advance notice as specified in your agent agreement. Grounds for termination may include breach of contract, violation of company policies, or other reasons deemed appropriate by the company.
            </p>

            <h2>5. Acceptance of Terms</h2>
            <p>
                By applying to become an agent of our company, you acknowledge that you have read, understood, and agree to abide by these terms and conditions. Failure to comply with these terms may result in termination of your contract and other legal consequences.
            </p>
        </div>


        <label for="accept_terms">
            <input type="checkbox" id="accept_terms" name="accept_terms" required>
            I have read and agree to the terms and conditions
        </label><br>
        <input type="submit" value="Submit Application">
        <script>
            function validate() {
                var x = document.getElementById("password");
                var y = document.getElementById("confirm_password");
                if (x.value == y.value) return;
                else alert("Password Not Matched!");
            }
        </script>

    </form>
    <script>
        function showTerms() {
            var termsDiv = document.getElementById("terms");
            var showTermsBtn = document.getElementById("showTermsBtn");
            if (termsDiv.style.display === "none") {
                termsDiv.style.display = "block";
                showTermsBtn.textContent = "Hide Terms and Conditions";
            } else {
                termsDiv.style.display = "none";
                showTermsBtn.textContent = "View Terms and Conditions";
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            showTerms();
        });
    </script>
    </div>
</body>
</html>