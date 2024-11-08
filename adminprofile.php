<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="adminhomepage.css">
    <link rel="stylesheet" href="adminprofile.css">
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
        <h1>Admin Profile</h1>
        <div class="profile-card">
            <div class="profile-info">
                <p><strong>Name:</strong> <span id="name"></span></p>
                <p><strong>Email:</strong> <span id="email"></span></p>
                <p><strong>Phone:</strong> <span id="phone"></span></p>
            </div>
            <button id="editButton">Edit Profile</button>
        </div>

        <div id="editForm" style="display: none;">
            <h2>Edit Profile</h2>
            <form id="updateForm">
                <label for="editName">Name:</label>
                <input type="text" id="editName" name="name" required>
                <br>
                <label for="editPhone">Phone:</label>
                <input type="text" id="editPhone" name="phone" required>
                <br>
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>

    <script>
        // Fetch admin data from processadminprofile.php and update the fields
        fetch('processadminprofile.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    alert("You need to log in as an admin.");
                    window.location.href = "adminlogin.php"; // Redirect to admin login page if not logged in
                } else {
                    document.getElementById('name').textContent = data.name || 'N/A';
                    document.getElementById('email').textContent = data.email || 'N/A';
                    document.getElementById('phone').textContent = data.phone || 'N/A';

                    // Populate the edit form with current data
                    document.getElementById('editName').value = data.name || '';
                    document.getElementById('editPhone').value = data.phone || '';
                }
            })
            .catch(error => console.error('Error fetching admin data:', error));

        // Show edit form when "Edit Profile" button is clicked
        document.getElementById('editButton').addEventListener('click', () => {
            document.getElementById('editForm').style.display = 'block';
        });

        // Handle form submission for profile update
        document.getElementById('updateForm').addEventListener('submit', (event) => {
            event.preventDefault();

            const name = document.getElementById('editName').value;
            const phone = document.getElementById('editPhone').value;

            fetch('updateadminprofile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    name: name,
                    phone: phone
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profile updated successfully!');
                    // Update displayed values
                    document.getElementById('name').textContent = name;
                    document.getElementById('phone').textContent = phone;
                    document.getElementById('editForm').style.display = 'none';
                } else {
                    alert('Error updating profile: ' + data.error);
                }
            })
            .catch(error => console.error('Error updating profile:', error));
        });
    </script>
</body>
</html>
