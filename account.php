<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="account.css">
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

        <div class="usercontent">
            <h1>User Profile</h1>
            <div class="userprofile-card">
                <div class="userprofile-info">
                    <p><strong>Name:</strong> <span id="name"></span></p>
                    <p><strong>Email:</strong> <span id="email"></span></p>
                    <p><strong>Phone:</strong> <span id="phone"></span></p>
                </div>
                <button id="editButton">Edit Profile</button>
                <button id="logoutButton">Logout</button> <!-- New Logout Button -->
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

            <script>
                // Fetch user data from processprofile.php and update the fields
                fetch('processprofile.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                            alert("You need to log in as a user.");
                            window.location.href = "login.php"; // Redirect to user login page if not logged in
                        } else {
                            document.getElementById('name').textContent = data.name || 'N/A';
                            document.getElementById('email').textContent = data.email || 'N/A';
                            document.getElementById('phone').textContent = data.phone || 'N/A';

                            // Populate the edit form with current data
                            document.getElementById('editName').value = data.name || '';
                            document.getElementById('editPhone').value = data.phone || '';
                        }
                    })
                    .catch(error => console.error('Error fetching user data:', error));

                // Show edit form when "Edit Profile" button is clicked
                document.getElementById('editButton').addEventListener('click', () => {
                    document.getElementById('editForm').style.display = 'block';
                });

                // Handle form submission for profile update
                document.getElementById('updateForm').addEventListener('submit', (event) => {
                    event.preventDefault();

                    const name = document.getElementById('editName').value;
                    const phone = document.getElementById('editPhone').value;

                    fetch('processupdateprofile.php', {
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

                // Handle logout button click
                document.getElementById('logoutButton').addEventListener('click', () => {
                    fetch('logout.php')
                        .then(() => {
                            alert('Logged out successfully!');
                            window.location.href = "login.php"; // Redirect to login page after logout
                        })
                        .catch(error => console.error('Error logging out:', error));
                });
            </script>
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
</body>

</html>
