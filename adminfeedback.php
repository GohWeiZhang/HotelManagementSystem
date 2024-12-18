<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client Page</title>
    <link rel="stylesheet" href="adminfeedback.css">
</head>

<body>
    <header>
        <a href="adminhomepage.php" class="logo">Admin</a>
    </header>

    <div class="sidenav">
        <a href="adminhomepage.php">Dashboard</a>
        <a href="adminclient.php">Clients</a>
        <a href="adminfeedback.php">Feedback</a>
        <a href="adminrooms.php">Rooms</a>
        <a href="adminbooking.php">Bookings</a>
        <a href="adminprofile.php">My Profile</a>
        <a href="adminlogin.php">Logout</a>
    </div>

    <div class="content">
        <h2>Feedback Information</h2>
        <table id="feedbackTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody id="feedbackTableBody">
                <!-- Client data will be inserted here -->
            </tbody>
        </table>
    </div>


    <script>

    // Fetch client data when the page loads
    window.onload = function() {
        fetch('processfeedbackinformation.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('feedbackTableBody');
                data.forEach(feedback => {
                    const row = tableBody.insertRow();
                    row.insertCell(0).textContent = feedback.title; // Fix here
                    row.insertCell(1).textContent = feedback.comment; // Fix here
                });
            })
            .catch(error => console.error('Error:', error));
    };
    </script> 
    
</body>

</html>