<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="homepage.css">
</head>

<body>
    <section class="sec">
        <header>
            <a href="homepage.php" class="logo">Dreamy Dreamer</a>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="chatbot.php">Facilities&Events</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="userbooking.php">Booking</a></li>
                <li><a href="chatbot.php">Inquiries Chatbot</a></li>
            </ul>
        </header>

        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="hotel1.jpg" alt="Image 1"></div>
                <div class="slide"><img src="hotel2.jpg" alt="Image 2"></div>
                <div class="slide"><img src="hotel3.jpg" alt="Image 3"></div>
                <!-- Add more slides as needed -->
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <div class="description">
            <h1>A HEAVEN OF ELEGANCE AT DREAMY DREAMER</h1>
            <p><strong>Dreamy Dreamer</strong> Welcome to Dreamy Dreamer, where timeless elegance meets contemporary comfort. Our hotel offers an enchanting escape with its blend of classic charm and modern amenities. From elegantly designed rooms to exceptional
                service, every detail at Dreamy Dreamer is crafted to create an unforgettable experience. Whether you're seeking a serene retreat or a luxurious stay in a vibrant city, our dedicated team is here to ensure your visit is nothing short of
                extraordinary. Embrace the essence of true relaxation and let Dreamy Dreamer be your gateway to unparalleled tranquility and sophistication.</p>
        </div>
    </section>

    <footer>
    <div class="footer-content">
        <p>&copy; 2024 Dreamy Dreamer. All rights reserved.</p>
        <ul>
            <li><a href="https://www.jsm.gov.my/privacy-policy">Privacy Policy</a></li>
            <li><a href="https://www.pmo.gov.my/terms-condition/">Terms of Service</a></li>
            <li><a href="contactus.php">Sitemap</a></li>
        </ul>
    </div>

</footer>


    <!-- Chatbot script -->
    <script>
        !function(e,t,a){
            var c=e.head||e.getElementsByTagName("head")[0],
            n=e.createElement("script");
            n.async=!0,
            n.defer=!0,
            n.type="text/javascript",
            n.src=t+"/static/js/widget.js?config="+JSON.stringify(a),
            c.appendChild(n)
        }(document,"https://app.engati.com",{
            bot_key:"768abc75d45849e2",
            welcome_msg:true,
            branding_key:"default",
            server:"https://app.engati.com",
            e:"p"
        });
    </script>

    <script src="slider.js"></script>
</body>

</html>
