<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="forgetpassword.css">
    <title>Forget Password</title>
</head>
<body>
    <div class="forgetbox">
        <div class="forgetheader">
            <header>Forget Password</header>
        </div>

        <form action="processforgetpassword.php" method="POST">
            <div class="inputbox">
                <input type="email" name="email" class="inputfield" placeholder="Email" autocomplete="off" required>
            </div>

            <div class="inputbox">
                <input type="password" name="password" class="inputfield" placeholder="Password" autocomplete="off" required>
            </div>

            <div class="inputsubmit">
                <button type="submit" class="submitbtn">Submit</button>
            </div>

            <div class="inputsubmit">
                <button type="button" class="submitbtn" onclick="window.location.href='login.php';">Back</button>
            </div>
            

            </div>
        </form>
    </div>
</body>
</html>
