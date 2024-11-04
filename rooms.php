<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link rel="stylesheet" href="rooms.css">
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

        <div id="room-list" class="room-list">
            <!-- Rooms will be populated here -->
        </div>
    </section>

    <script>
        fetch('fetch_rooms.php?action=list')
            .then(response => response.json())
            .then(rooms => {
                const roomList = document.getElementById('room-list');
                rooms.forEach(room => {
                    const roomDiv = document.createElement('div');
                    roomDiv.classList.add('room-item');
                    roomDiv.innerHTML = `
                        <div class="room-content">
                            ${room.image ? `<img src="uploads/${room.image}" alt="${room.name}" />` : ''}
                            <div class="room-details">
                                <h3>Room Name: ${room.name}</h3>
                                <p>Price: RM ${room.price}</p>
                                <p>Description: ${room.description}</p>
                                <button class="select-button" onclick="selectRoom('${room.name}', ${room.price}, '${room.image}')">Select</button>
                            </div>
                        </div>
                    `;
                    roomList.appendChild(roomDiv);
                });
            })
            .catch(error => console.error('Error fetching rooms:', error));

        function selectRoom(roomName, roomPrice, roomImage) {
            // Store room details in local storage
            localStorage.setItem('selectedRoom', JSON.stringify({ name: roomName, price: roomPrice, image: roomImage }));
            // Redirect to bookings.php
            window.location.href = 'bookings.php';
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
