<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
</head> 
<body>
    <div class="loginbox">
        <div class="loginheader">
            <header>Login</header>
        </div>

        <form action="process_login.php" method="POST">
            <div class="inputbox">
                <input type="email" name="email" class="inputfield" placeholder="Email" autocomplete="off" required>
            </div>

            <div class="inputbox">
                <input type="password" name="password" class="inputfield" placeholder="Password" autocomplete="off" required>
            </div>

            <div class="forgotpassword">
                <section>
                    <a href="forgetpassword.php">Forgot Password</a>
                </section>
            </div>

            <div class="inputsubmit">
                <button type="submit" class="submitbtn">Sign In</button>
            </div>

            <div class="signuplink">
                <section>
                    <p>Don't Have An Account? <a href="signup.php">Sign Up</a></p>
                </section>
            </div>
        </form>
    </div>

</body>
</html>
