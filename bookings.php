<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <h1>Book Your Room</h1>
    <div id="room-info"></div>

    <form id="booking-form">
        <label for="people">Number of People:</label>
        <select id="people" required>
            <option value="">Select</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>

        <label for="checkin">Check-in:</label>
        <input type="date" id="checkin" required>
        
        <label for="checkout">Check-out:</label>
        <input type="date" id="checkout" required>
        
        <button type="submit">Proceed to Payment</button>
    </form>

    <script>
        // Load selected room info from local storage
        const roomInfo = JSON.parse(localStorage.getItem('selectedRoom'));
        if (roomInfo) {
            document.getElementById('room-info').innerHTML = `
                <h2>Selected Room: ${roomInfo.name}</h2>
                <p>Price: RM ${roomInfo.price}</p>
                ${roomInfo.image ? `<img src="uploads/${roomInfo.image}" alt="${roomInfo.name}" />` : '<img src="default-room.jpg" alt="Default Room Image" />'}
            `;
        } else {
            document.getElementById('room-info').innerHTML = `<p>No room selected.</p>`;
            document.getElementById('booking-form').style.display = 'none'; // Hide the form if no room is selected
        }

        // Date validation
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        const yyyy = today.getFullYear();
        const minDate = `${yyyy}-${mm}-${dd}`;

        // Set the minimum date for check-in
        document.getElementById('checkin').setAttribute('min', minDate);

        // Add event listener for check-in date
        document.getElementById('checkin').addEventListener('change', function() {
            const checkinDate = new Date(this.value);
            checkinDate.setDate(checkinDate.getDate() + 1); // Minimum check-out date is the next day
            const checkOutMin = `${checkinDate.getFullYear()}-${String(checkinDate.getMonth() + 1).padStart(2, '0')}-${String(checkinDate.getDate()).padStart(2, '0')}`;
            document.getElementById('checkout').setAttribute('min', checkOutMin);
        });
 
        document.getElementById('booking-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const numberOfPeople = parseInt(document.getElementById('people').value, 10);
            const checkInDate = document.getElementById('checkin').value;
            const checkOutDate = document.getElementById('checkout').value;

            // Store the number of people in local storage
            localStorage.setItem('numberOfPeople', numberOfPeople);

            if (numberOfPeople > 2 && (roomInfo.name !== 'Deluxe Room' && roomInfo.name !== 'Executive Suite')) {
                alert('Only Deluxe or Executive rooms can accommodate 2 or more people. Please choose a different room.');
                window.location.href = 'rooms.php'; // Redirect back to rooms.php
            } else {
                // Store check-in and check-out dates in local storage
                localStorage.setItem('checkInDate', checkInDate);
                localStorage.setItem('checkOutDate', checkOutDate);
                // Redirect to payment.html
                window.location.href = 'payment.php';
            }
        });
    </script>
</body>
</html>
