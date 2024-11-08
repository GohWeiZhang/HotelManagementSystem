<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminforgetpassword.css">
    <title>Forget Password</title>
</head>
<body>
    <div class="adminloginbox">
        <div class="adminloginheader">
            <header>Admin Forget Password</header>
        </div>

        <form action="processadminforgetpassword.php" method="POST" onsubmit="handleFormSubmission(event)">
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
                <button type="button" class="submitbtn" onclick="window.location.href='adminlogin.php';">Back</button>
            </div>
        </form>
    </div>

    <script>
        function handleFormSubmission(event) {
            event.preventDefault(); // Prevent the form from submitting normally
    
            var formData = new FormData(event.target);
            
            fetch('processadminforgetpassword.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    window.location.href = 'adminlogin.php';
                } else {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
    
</body>

</html>
