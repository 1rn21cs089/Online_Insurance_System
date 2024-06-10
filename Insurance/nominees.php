<!DOCTYPE html>
<html>
<head>
    <title>NOMINEE</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 800px;
            margin-bottom: 20px;
        }

        .nominee-container {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        select {
            height: 36px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            margin-right: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ccc;
        }

        .nominee-heading {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
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

                    
                    echo "<h2>CLIENT DETAILS</h2>";
                    echo "<div class='nominee-container'>";
                    echo "<label for='clientId'>Client ID:</label>";
                    echo "<input type='text' name='clientId' value='".$clientInfoRow["Client_Id"]."' readonly>";
                    echo "</div>";

                    echo "<div class='nominee-container'>";
                    echo "<label for='clientName'>Client Name:</label>";
                    echo "<input type='text' name='clientName' value='".$clientInfoRow["Fname"]." ".$clientInfoRow["Lname"]."' readonly>";
                    echo "</div>";

                    echo "<div class='nominee-container'>";
                    echo "<label for='clientEmail'>Client Email:</label>";
                    echo "<input type='text' name='clientEmail' value='".$clientInfoRow["Email"]."' readonly>";
                    echo "</div>";

                    
                    echo "<form class='nominee' action='nominee.php' method='post'>";
                    echo "<h2>NOMINEE ADDITION</h2>";

                    
                    echo "<div class='nominee-container'>";
                    echo "<h3 class='nominee-heading'>First Nominee</h3>";
                    echo "<label for='nomineeName'>Nominee's Name:</label>";
                    echo "<input type='text' name='nomineeName[]' required>";

                    echo "<label for='nomineeAge'>Nominee's Age:</label>";
                    echo "<input type='text' name='nomineeAge[]' required>";

                    echo "<label for='nomineeGender'>Nominee's Gender:</label>";
                    echo "<select name='nomineeGender[]' required>";
                    echo "<option value='' disabled selected>Select Gender</option>";
                    echo "<option value='Female'>Female</option>";
                    echo "<option value='Male'>Male</option>";
                    echo "<option value='Other'>Other</option>";
                    echo "</select>";

                    echo "<label for='relationship'>Relationship:</label>";
                    echo "<input type='text' name='relationship[]' required>";
                    echo "</div>";

                    
                    echo "<div id='nomineeContainer'></div>";
                    echo "<button type='button' onclick='addNominee()'>Add Another Nominee</button>";

                    
                    echo "<button class='btn btn-danger btn-lg mb-1' type='submit'>Continue</button>";
                    echo "</form>";
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

    <script>
        function addNominee() {
        var nomineeContainer = document.getElementById('nomineeContainer');
        var newNominee = document.createElement('div');
        newNominee.classList.add('nominee-container');

        newNominee.innerHTML = `
            <h3 class='nominee-heading'>Second Nominee</h3>
            <label for="nomineeName">Nominee's Name:</label>
            <input type="text" name="nomineeName[]" required>

            <label for="nomineeAge">Nominee's Age:</label>
            <input type="text" name="nomineeAge[]" required>

            <label for="nomineeGender">Nominee's Gender:</label>
            <select name="nomineeGender[]" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
            </select>

            <label for="relationship">Relationship:</label>
            <input type="text" name="relationship[]" required>
            <button type='button' onclick='removeNominee(this)'>Remove Nominee</button>
        `;

        nomineeContainer.appendChild(newNominee);
    }

        function removeNominee(button) {
            var nomineeContainer = button.parentNode;
            nomineeContainer.remove();
        }
    </script>
</body>
</html>