<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Dreamy Dreamer</title>
    <link rel="stylesheet" href="chatbot.css">
</head>
<body>
    <section class="sec">
        <header>
            <a href="homepage.php" class="logo">Dreamy Dreamer</a>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="facilities.php">Facilities & Events</a></li>
                <li><a href="contactus.php">Contact Us</a></li>
                <li><a href="rooms.php">Rooms</a></li>
                <li><a href="account.php">Account</a></li>
                <li><a href="userbooking.php">Booking</a></li>
                <li><a href="chatbot.php">Inquiries Chatbot</a></li>
            </ul>
        </header>

        <div class="chat-container">
            <div class="chat-header">
                <h2>Inquiries Chatbot</h2>
            </div>
            <div class="chat-box" id="chat-box">
                <div class="chat-message" id="welcome-message"></div>
            </div>
            <div class="chat-input">
                <input type="text" id="user-input" placeholder="Type your inquiry here...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </section>

    <script>
        let selectedRoom = null; // To store selected room information
        let numberOfPeople = 0; // To store number of people

        // Set today's date for date input restrictions
        const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD

        // Fetch the user's name from the PHP script
        fetch('fetchchatbot.php')
            .then(response => response.json())
            .then(data => {
                const welcomeMessage = data.error 
                    ? 'Welcome Guest, what can I help you with the hotel booking?' 
                    : 'Welcome ' + data.name + ', what can I help you with the hotel booking?';

                document.getElementById('welcome-message').innerHTML = welcomeMessage;

                // After welcome message, ask what room the user is looking for
                setTimeout(() => {
                    const chatBox = document.getElementById('chat-box');
                    const roomInquiryDiv = document.createElement('div');
                    roomInquiryDiv.classList.add('chat-message');
                    roomInquiryDiv.innerHTML = '<strong>Bot:</strong> What room are you looking for? (Please input room)';
                    chatBox.appendChild(roomInquiryDiv);
                }, 1000);
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                document.getElementById('welcome-message').innerHTML = 'Welcome Guest, what can I help you with the hotel booking?';
            });

        // Function to send a message
        function sendMessage() {
            const userInput = document.getElementById('user-input');
            const message = userInput.value.trim();

            if (message) {
                // Display the user's message in the chat box
                const chatBox = document.getElementById('chat-box');
                const userMessageDiv = document.createElement('div');
                userMessageDiv.classList.add('chat-message');
                userMessageDiv.innerHTML = '<strong>You:</strong> ' + message;
                chatBox.appendChild(userMessageDiv);

                // Clear the input field
                userInput.value = '';

                // Check if the message is about room inquiries
                if (message.toLowerCase().includes('room')) {
                    setTimeout(() => {
                        fetchRoomDetails(); // Fetch room details based on user inquiry
                    }, 1000);
                } else {
                    // Simulate a chatbot response for other messages
                    setTimeout(() => {
                        const botMessageDiv = document.createElement('div');
                        botMessageDiv.classList.add('chat-message');
                        botMessageDiv.innerHTML = '<strong>Bot:</strong> I only help with room booking, other inquries kindly go to the Hotel Inquiries chatbot at the Homepage. '; // Placeholder response
                        chatBox.appendChild(botMessageDiv);
                    }, 1000);
                }
            }
        }

        function fetchRoomDetails() {
            fetch('chatbotfetchroom.php?action=list')
                .then(response => response.json())
                .then(rooms => {
                    const chatBox = document.getElementById('chat-box');

                    rooms.forEach(room => {
                        const roomMessageDiv = document.createElement('div');
                        roomMessageDiv.classList.add('chat-message');
                        roomMessageDiv.innerHTML = ` 
                            <strong>Bot:</strong> 
                            <p>Room Name: ${room.name}</p>
                            <p>Price: RM ${room.price}</p>
                            <img src="uploads/${room.image}" alt="${room.name}" style="width: 100px; height: auto;"/><br/>
                            <button onclick="selectRoom('${room.name}', ${room.price}, '${room.image}')">Select</button>
                        `;
                        chatBox.appendChild(roomMessageDiv);
                    });
                })
                .catch(error => console.error('Error fetching rooms:', error));
        }

        function selectRoom(roomName, roomPrice, roomImage) {
            selectedRoom = { name: roomName, price: roomPrice, image: roomImage };
            const chatBox = document.getElementById('chat-box');
            const selectionMessageDiv = document.createElement('div');
            selectionMessageDiv.classList.add('chat-message');
            selectionMessageDiv.innerHTML = `
                <strong>Bot:</strong>
                <p>You have selected the room: ${roomName}</p>
                <p>Price: RM ${roomPrice}</p>
                <strong>How many people will be staying?</strong>
                <input type="number" id="people-input" min="1" onchange="updateNumberOfPeople(this.value)">
            `;
            chatBox.appendChild(selectionMessageDiv);
        }

        function updateNumberOfPeople(value) {
            numberOfPeople = parseInt(value);
            const chatBox = document.getElementById('chat-box');

            if (numberOfPeople > 2 && selectedRoom.name.toLowerCase().includes('standard')) {
                const errorMessageDiv = document.createElement('div');
                errorMessageDiv.classList.add('chat-message');
                errorMessageDiv.innerHTML = '<strong>Bot:</strong> You cannot select the Standard Room for more than 2 people. Please select a different room.';
                chatBox.appendChild(errorMessageDiv);
                // Optionally reset the selection
                selectedRoom = null;
                numberOfPeople = 0;
                // Ask to go back to room selection
                setTimeout(() => {
                    fetchRoomDetails(); // Fetch room details again for the user to choose a different room
                }, 2000);
            } else if (numberOfPeople <= 0) {
                const errorMessageDiv = document.createElement('div');
                errorMessageDiv.classList.add('chat-message');
                errorMessageDiv.innerHTML = '<strong>Bot:</strong> The number of people must be at least 1. Please enter a valid number of people.';
                chatBox.appendChild(errorMessageDiv);
                numberOfPeople = 0; // Reset number of people
            } else {
                // Proceed to the next step if number of people is valid
                proceedToDates();
            }
        }

        function proceedToDates() {
            if (selectedRoom === null || numberOfPeople <= 0) {
                // If no room is selected or invalid number of people, do not show dates
                return;
            }

            const chatBox = document.getElementById('chat-box');
            const dateMessageDiv = document.createElement('div');
            dateMessageDiv.classList.add('chat-message');
            dateMessageDiv.innerHTML = `
                <strong>Bot:</strong>
                <strong>Please enter the check-in and check-out dates:</strong><br/>
                Check-in Date: <input type="date" id="checkin-date" onchange="validateDates()" min="${today}"><br/>
                Check-out Date: <input type="date" id="checkout-date" onchange="validateDates()" min="${today}">
            `;
            chatBox.appendChild(dateMessageDiv);
        }

        function validateDates() {
            const checkInDate = document.getElementById('checkin-date').value;
            const checkOutDate = document.getElementById('checkout-date').value;

            if (checkInDate && checkOutDate) {
                const checkIn = new Date(checkInDate);
                const checkOut = new Date(checkOutDate);

                if (checkIn >= checkOut) {
                    alert("Check-out date must be after check-in date. Please select valid dates.");
                    return;
                }

                // Ask for confirmation before proceeding to payment
                const confirmation = confirm(`You have selected the following:\nRoom: ${selectedRoom.name}\nNumber of People: ${numberOfPeople}\nCheck-in Date: ${checkInDate}\nCheck-out Date: ${checkOutDate}\nDo you want to proceed to payment?`);

                if (confirmation) {
                    // Save the dates to local storage
                    localStorage.setItem('checkInDate', checkInDate);
                    localStorage.setItem('checkOutDate', checkOutDate);
                    alert('Booking confirmed! Proceeding to payment.');
                    // Proceed to payment page
                    localStorage.setItem('selectedRoom', JSON.stringify(selectedRoom));
                    localStorage.setItem('numberOfPeople', numberOfPeople);
                    window.location.href = 'payment.php'; // Redirect to payment page
                }
            }
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
