<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contactus.css">
</head>

<body>
    <section class="sec">
        <header>
            <a href="homepage.php" class="logo">Dreamy Dreamer</a>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="facilities.php">Facilities&Events</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="userbooking.php">Booking</a></li>
                <li><a href="chatbot.php">Inquiries Chatbot</a></li>
            </ul>
        </header>
 
        <div class="ContactUs">
            <h2>Contact Us</h2>
        </div>

        <div class="ContactInfo">
            <div class="Management">
                <h6>This website provides a broad overview of the Dreamy Dreamer Hotel. If you would like more detailed information about our hotel, please contact us.</h6>
            </div>

            <div class="Sales">
                <h6>Sales</h6>
                <p>Emails: sales@dreamy.com</p>
            </div>

            <div class="Location">
                <h6>Location</h6>
                <p>Location: 22 Batu Ferringhi, 11100 Penang, Malaysia</p>
            </div>
        </div>

        <div class="feedback-form">
            <h2>Feedback Form</h2>
            <form action="processfeedback.php" method="post">

                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>

                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" required></textarea>

                <input type="submit" value="Submit Feedback">
            </form>
        </div>

        <div class="container">
            <h1>Map</h1>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15886.670564507145!2d100.24472591133144!3d5.467292272369165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ae805c113b9f5%3A0xe1af84e922dab25c!2sBatu%20Ferringhi%2C%20Penang!5e0!3m2!1sen!2smy!4v1725697886448!5m2!1sen!2smy"
                width="1900" height="850" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('feedback') && urlParams.get('feedback') === 'success') {
            alert("Thank you for your feedback!");
        }
    </script>

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
    
</body>

</html>
