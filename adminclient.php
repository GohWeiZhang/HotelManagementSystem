<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Client Page</title>
    <link rel="stylesheet" href="adminclient.css">
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
        <h2>Client Information</h2>
        <table id="clientTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody id="clientTableBody">
                <!-- Client data will be inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch client data when the page loads
        window.onload = function() {
            fetch('processclientinformation.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('clientTableBody');
                    data.forEach(client => {
                        const row = tableBody.insertRow();
                        row.insertCell(0).textContent = client.name;
                        row.insertCell(1).textContent = client.phone;
                        row.insertCell(2).textContent = client.email;
                    });
                })
                .catch(error => console.error('Error:', error));
        };
    </script>
</body>

</html>