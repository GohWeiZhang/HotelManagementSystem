
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <title>SignUp</title>
</head>
<body>
    <div class="signup">
        <div class="signupheader">
            <header>SignUp</header>
        </div>

        <form action="process_signup.php" method="POST">
            <div class="inputbox">
                <input type="text" name="name" class="inputfield" placeholder="Name" autocomplete="off" required>
            </div>

            <div class="inputbox">
                <input type="email" name="email" class="inputfield" placeholder="Email" autocomplete="off" required>
            </div>

            <div class="inputbox">
                <input type="tel" name="phone" class="inputfield" placeholder="Phone Number" autocomplete="off" required>
            </div>

            <div class="inputbox">
                <input type="password" name="password" class="inputfield" placeholder="Password" autocomplete="off" required>
            </div>

            <div class="inputsubmit">
                <button type="submit" class="submitbtn" id="submit">Sign Up</button>
            </div>
        </form>

        <div class="signuplink">
            <section>
                <p>Already Have An Account? <a href="login.php">Log In</a></p>
            </section>
        </div>
    </div>
</body>
</html>

