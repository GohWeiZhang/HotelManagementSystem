<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="payment.css">
</head>
<body>
    <h1>Payment Information</h1>
    
    <div class="info-box" id="booking-details">
        <!-- Booking details will be displayed here -->
    </div>
    
    <div class="info-box user-info" id="user-info">
        <!-- User info will be displayed here -->
    </div>
 
    <div class="price-box" id="price-info">
        <h2>Price Details</h2>
        <p id="price">Price: RM 0.00</p>
        <p id="service-tax">Service Tax (10%): RM 0.00</p>
        <p id="consumption-tax">Consumption Tax (8%): RM 0.00</p>
        <h3 id="total-amount">Total Amount: RM 0.00</h3>
    </div>

    <div class="card-payment-box">
        <h2>Card Payment</h2>
        <form id="card-payment-form">
            <label for="card_number">Credit Card Number:</label>
            <input type="text" id="card_number" name="card_number" required maxlength="16" pattern="\d{16}" title="Must be 16 digits">

            <label for="name_on_card">Name on Card:</label>
            <input type="text" id="name_on_card" name="name_on_card" required>

            <label for="expiry_date">Expiry Date:</label>
            <input type="text" id="expiry_date" name="expiry_date" required maxlength="5" pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="Format: MM/YY" placeholder="MM/YY">

            <label for="security_code">Security Code:</label>
            <input type="text" id="security_code" name="security_code" required maxlength="3" pattern="\d{3}" title="Must be 3 digits">

            <input type="hidden" id="room-name" name="room_name">
            <input type="hidden" id="checkin-date" name="checkin_date">
            <input type="hidden" id="checkout-date" name="checkout_date">
            <input type="hidden" id="total-price" name="total_price">
            <input type="hidden" id="user-name" name="user_name">
            <input type="hidden" id="user-email" name="user_email">
            <input type="hidden" id="user-phone" name="user_phone">
            <input type="hidden" id="booking-id" name="booking_id">
            <input type="hidden" id="number-of-people" name="number_of_people"> <!-- Hidden field for number of people -->
          
            <button type="submit">Confirm Payment</button>
            <button id="back-button" type="button" onclick="window.location.href='rooms.php'">Back</button>
        </form>
    </div>

    <script>
        // Function to calculate days between two dates
        function calculateDays(checkIn, checkOut) {
            const checkInDate = new Date(checkIn);
            const checkOutDate = new Date(checkOut);
            const timeDifference = checkOutDate - checkInDate;
            const daysDifference = timeDifference / (1000 * 3600 * 24); // Convert milliseconds to days
            return daysDifference;
        }

        // Function to calculate prices
        function calculatePrices(roomPrice) {
            const checkInDate = localStorage.getItem('checkInDate');
            const checkOutDate = localStorage.getItem('checkOutDate');
            
            const numberOfDays = calculateDays(checkInDate, checkOutDate);

            if (numberOfDays <= 0) {
                alert("Invalid date range. Check-out date must be after check-in date.");
                return;
            }

            const totalRoomPrice = roomPrice * numberOfDays;
            const serviceTaxRate = 0.10; // 10%
            const consumptionTaxRate = 0.08; // 8%
            const serviceTax = totalRoomPrice * serviceTaxRate;
            const consumptionTax = totalRoomPrice * consumptionTaxRate;
            const totalAmount = totalRoomPrice + serviceTax + consumptionTax;

            // Update the price information on the page
            document.getElementById('price').innerText = `Price for ${numberOfDays} night(s): RM ${totalRoomPrice.toFixed(2)}`;
            document.getElementById('service-tax').innerText = `Service Tax (10%): RM ${serviceTax.toFixed(2)}`;
            document.getElementById('consumption-tax').innerText = `Consumption Tax (8%): RM ${consumptionTax.toFixed(2)}`;
            document.getElementById('total-amount').innerText = `Total Amount: RM ${totalAmount.toFixed(2)}`;
            
            // Store total price in hidden field
            document.getElementById('total-price').value = totalAmount.toFixed(2);
        }

        // Load booking information from local storage
        const roomInfo = JSON.parse(localStorage.getItem('selectedRoom'));
        const checkInDate = localStorage.getItem('checkInDate');
        const checkOutDate = localStorage.getItem('checkOutDate');
        const numberOfPeople = localStorage.getItem('numberOfPeople'); // Get number of people

        if (roomInfo && checkInDate && checkOutDate) {
            document.getElementById('booking-details').innerHTML = `
                <h2>Selected Room: ${roomInfo.name}</h2>
                <p>Check-in Date: ${checkInDate}</p>
                <p>Check-out Date: ${checkOutDate}</p>
                <p>Number of People: ${numberOfPeople}</p> <!-- Display number of people -->
                <p>Price: RM ${roomInfo.price}</p>
               ${roomInfo.image ? `<img src="uploads/${roomInfo.image}" alt="${roomInfo.name}" style="width: 300px; height: auto;" />` : '<img src="default-room.jpg" alt="Default Room Image" style="width: 300px; height: auto;" />'}
            `;
            calculatePrices(roomInfo.price);
        } else {
            document.getElementById('booking-details').innerHTML = `<p>No booking information available.</p>`;
        }

        // Fetch user info
        fetch('fetchuserinfo.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('user-info').innerHTML = `<p>${data.error}</p>`;
                } else {
                    document.getElementById('user-info').innerHTML = `
                        <h2>User Information</h2>
                        <p>Name: ${data.name}</p>
                        <p>Email: ${data.email}</p>
                        <p>Phone: ${data.phone}</p>
                    `;
                    
                    // Store user data in hidden fields
                    document.getElementById('user-name').value = data.name;
                    document.getElementById('user-email').value = data.email;
                    document.getElementById('user-phone').value = data.phone;
                }
            })
            .catch(error => console.error('Error fetching user info:', error));

        // Handle card payment form submission
        document.getElementById('card-payment-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Generate a random booking ID
            const bookingID = Math.floor(10000000 + Math.random() * 90000000);
            document.getElementById('booking-id').value = bookingID;

            // Store room info in hidden fields
            document.getElementById('room-name').value = roomInfo.name;
            document.getElementById('checkin-date').value = checkInDate;
            document.getElementById('checkout-date').value = checkOutDate;
            document.getElementById('number-of-people').value = numberOfPeople; // Store number of people

            // Submit the form via fetch to a PHP script
            const formData = new FormData(document.getElementById('card-payment-form'));
            fetch('process_payment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Payment successful!');
                    window.location.href = 'homepage.php'; // Redirect to homepage
                } else {
                    // Show an alert if payment fails
                    alert('Payment failed: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error during payment processing:', error);
                alert('An unexpected error occurred. Please try again later.');
            });
        });

        // Format expiry date input
        document.getElementById('expiry_date').addEventListener('input', function(e) {
            const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
            if (value.length > 2) {
                e.target.value = value.slice(0, 2) + '/' + value.slice(2, 4); // Insert slash after MM
            } else {
                e.target.value = value; // For MM only
            }
        });
    </script>
</body>
</html>
