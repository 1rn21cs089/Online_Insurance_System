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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sample Website</title>
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
        }
        nav {
    text-align: right;
    background-color:#333 ;
    padding: 10px;}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

li {
    display: inline-block;
    position: relative; 
    margin:10px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #333;
    width:200px;
    z-index: 1;
}

.dropdown-menu li {
    display: block;
    text-align:center;
}

.dropdown-icon {
    font-size: 10px;
    margin-left: 5px;
}

.user:hover .dropdown-menu {
    display: block;
}

        nav ul li a {
                color: white;
                text-decoration: none;
                
        }

        .slider {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 1s ease-in-out; 
        }

            .slides img {
                width: 100%;
                height: 625px; 
                object-fit: cover; 
            }

        .prev,
        .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            z-index: 1;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }

        .about-us {
            padding: 20px 0;
        }

        .about-content {
            max-height: 50px;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .show-more-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

            .show-more-btn:hover {
                background-color: #555;
            }

        .section {
            padding: 20px 0;
        }

        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .card {
            width: 20%;
            margin-bottom: 20px;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            position: relative;
        }

            .card:hover {
                transform: translateY(-5px);
            }

        .card-content {
            margin-bottom: 20px;
        }

        .proceed-btn {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

            .proceed-btn:hover {
                background-color: #555;
            }

        .however-text {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: #666;
        }


        .service-image {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .service-card:hover .service-image {
            display: block;
        }


        .card-link {
            text-decoration: none;
            color: inherit;
            cursor: pointer;
        }
        .user{
            background:transparent;
            color:white;
            text-align:right;
        }
         .contact {
            text-align: center;
        }
        .contact h2 {
            margin-bottom: 20px;
            font-size: 30px;
        }
        .contact a {
            display: inline-block;
            margin: 10px;
            font-size: 20px;
            color: #333; 
            transition: transform 0.3s ease;
        }
        .contact a:hover {
            transform: scale(1.2); 
        }
        .contact p {
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
        <li class="user">
            <a href="#">
                Hi, <?php echo $fullName; ?> <span class="dropdown-icon">&#9662;</span>
            </a>
            <ul class="dropdown-menu">
                <li>Client Id:<br><?php echo $_SESSION['username']; ?></li>
                <li><hr></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </li>
    </ul>
</nav>

    <div class="slider">
        <div class="slides">
            <img src="https://media.istockphoto.com/id/1199060494/photo/insurance-protecting-family-health-live-house-and-car-concept.jpg?s=612x612&w=0&k=20&c=W8bPvwF5rk7Rm2yDYnMyFhGXZfNqK4bUPlDcRpKVsB8=" alt="Image 1">
            <img src="https://www.livelaw.in/h-upload/images/750x450_insurance-policy.jpg" alt="Image 2">
            <img src="https://taxguru.in/wp-content/uploads/2020/01/Insurance.jpg" alt="Image 3">
        </div>
        <button class="prev" onclick="prevSlide()">&#10094;</button>
        <button class="next" onclick="nextSlide()">&#10095;</button>
    </div>

    <section class="about-us section" id="about">
        <h2>About Us</h2>
        <div class="about-content">
            <p>Our mission is to empower individuals and businesses to achieve financial security and peace of mind through accessible and innovative insurance solutions. With a steadfast commitment to this mission, we endeavor to provide personalized service, tailored advice, and comprehensive coverage options to meet the unique needs of our clients.
        Our values serve as the cornerstone of our operations. We believe in integrity, transparency, and customer-centricity, and strive to uphold these values in every interaction. Our commitment to putting our clients first ensures that we deliver exceptional service and value at every turn.</p>
        </div>
        <button class="show-more-btn" onclick="toggleAboutContent()">See More</button>
    </section>

    <section class="policies section">
        <h2>Policies</h2>
        <div class="cards">
            <div class="card">
                <div class="card-content">
                    <h3>HEALTH</h3>
                    <p>Provides coverage for medical expenses incurred due to illness or injury.</div>
                     <button class="proceed-btn"><a href="policy11.php" class="card-link">Proceed</button></a>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>LIFE</h3>
                    <p>Offers financial protection to beneficiaries in the event of the insured's death, providing a lump sum payment.</div>
                     <button class="proceed-btn"><a href="policy12.php" class="card-link">Proceed</button></a>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>HOME</h3>
                    <p>Protects homeowners against financial losses from damage to their property or belongings, typically including coverage for hazards like fire, theft, and natural disasters.</div>
                     <button class="proceed-btn"><a href="policy13.php" class="card-link">Proceed</button></a>
            </div>
            
            <div class="card">
                <div class="card-content">
                    <h3>MOTOR</h3>
                    <p>Covers vehicles against damages caused by accidents, theft, or natural disasters, and may also include liability coverage for injuries or damages to others.</div>
                     <button class="proceed-btn"><a href="policy14.php" class="card-link">Proceed</button></a>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>GENERAL</h3>
                    <p>Encompasses a wide range of non-life insurance policies, such as travel insurance, liability insurance, and business insurance.</div>
                     <button class="proceed-btn"><a href="policy15.php" class="card-link">Proceed</button></a>
            </div>

            <div class="card">
                <div class="card-content">
                    <h3>RETIREMENT</h3>
                    <p>Provides financial security and income during retirement years, typically through investment or pension plans</div>
                        <button class="proceed-btn"><a href="policy6.html" class="card-link">Proceed</button></a>
            </div>
            
        </div>
    </section>

    <section class="services section">
        <h2>Services</h2>
        <div class="cards">
            <div class="card service-card">
                <a href="claims.php" class="card-link">
                    <div class="card-content">
                        <h3>CLAIM</h3>
                        <p>With this simple yet significant action, you're ensuring that your loved ones will receive the necessary support in the event of unforeseen circumstances.</p>
                    </div>
                    <img class="service-image" src="https://cdn5.vectorstock.com/i/1000x1000/63/94/claim-rubber-stamp-vector-12466394.jpg" alt="Service 1 Image">
                </a>


            </div>

            
            <div class="card service-card">
                <a href="agent1.php" class="card-link">
                    <div class="card-content">
                        <h3>BECOME AGENT</h3>
                        <p>Are you looking for a rewarding career opportunity that offers flexibility, growth potential, and the chance to make a positive impact in your community? Consider becoming an insurance agent with us!</p>
                    </div>
                    <img class="service-image" src="agent.jpg" alt="Service 3 Image">
                </a>


            </div>

            <div class="card service-card">
                <a href="withdraw_policy.php" class="card-link">
                    <div class="card-content">
                        <h3>WITHDRAW POLICY</h3>
                        <p>Our insurance withdrawal policy is designed to provide clarity and guidance to our policyholders who may need to make changes to their insurance coverage.</p>
                    </div>
                    <img class="service-image" src="withdraw.jpg" alt="Service 3 Image">
                </a>


            </div>

            <div class="card service-card">
                <a href="service6.php" class="card-link">
                    <div class="card-content">
                        <h3>ACCOUNT DETAILS</h3>
                        <p>View and manage your account details here. Update personal information, billing preferences, and more.</p>
                    </div>
                    <img class="service-image" src="user.jpg" alt="Service 3 Image">
                </a>


            </div>
            <div class="card service-card">
                <a href="renewal_pay.php" class="card-link">
                    <div class="card-content">
                        <h3>Renewal Payment</h3>
                        <p>Make renewal payments for your insurance policies here. Ensure your policies are up-to-date to maintain coverage.</p>
                    </div>
                    <img class="service-image" src="renewal.jpg" alt="Service 3 Image">
                </a>
            </div>


        </div>
    </section>

    <section class="contact section" id="contact">
        <h2>Contact Us</h2>
        <a href="#"><i class="fab fa-facebook"></i></a>
<a href="#"><i class="fab fa-instagram"></i></a>
<a href="#"><i class="far fa-envelope"></i></a>
<a href="#"><i class="fab fa-google"></i></a>
<p>Email: <a href="mailto:example@gmail.com">example@gmail.com</a></p>

    </section>

    <script>
    let slideIndex = 0;
        showSlides();

        function showSlides() {
            const slides = document.querySelectorAll('.slides img');
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = 'block';
            setTimeout(showSlides, 10000); 
        }

        function nextSlide() {
            slideIndex++;
            showSlides();
        }

        function prevSlide() {
            slideIndex--;
            showSlides();
        }

        function toggleAboutContent() {
            const aboutContent = document.querySelector('.about-content');
            const btnText = document.querySelector('.show-more-btn');
            if (aboutContent.style.maxHeight) {
                aboutContent.style.maxHeight = null;
                btnText.textContent = 'See More';
            } else {
                aboutContent.style.maxHeight = aboutContent.scrollHeight + 'px';
                btnText.textContent = 'See Less';
            }
        }</script>
</body>
</html>