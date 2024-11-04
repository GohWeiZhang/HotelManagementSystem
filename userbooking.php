<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="userbooking.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('fetchuserbooking.php')
                .then(response => response.json())
                .then(data => {
                    const bookingsTableBody = document.getElementById('bookingsTableBody');
                    if (data.success) {
                        if (data.bookings.length === 0) {
                            bookingsTableBody.innerHTML = '<tr><td colspan="8">No bookings found.</td></tr>';
                        } else {
                            data.bookings.forEach(booking => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${booking.booking_id}</td>
                                    <td>${booking.room_name}</td>
                                    <td>${booking.checkin_date}</td>
                                    <td>${booking.checkout_date}</td>
                                    <td>$${booking.total_price}</td>
                                    <td>${booking.user_name}</td>
                                    <td>${booking.user_phone}</td>
                                    <td>${booking.number_of_people}</td>
                                `;
                                bookingsTableBody.appendChild(row);
                            });
                        }
                    } else {
                        bookingsTableBody.innerHTML = `<tr><td colspan="8">Error: ${data.error}</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching bookings:', error);
                    document.getElementById('bookingsTableBody').innerHTML = '<tr><td colspan="8">Failed to fetch bookings.</td></tr>';
                });
        });
    </script>
</head>
<body>
    <header>
        <h1>Your Booking Details</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Price</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>People</th>
                </tr>
            </thead>
            <tbody id="bookingsTableBody">
                <!-- Booking details will be populated here -->
            </tbody>
        </table>
    </main>

    <div class="button-container">
        <a href="homepage.php" class="back-button">Back to Homepage</a>
    </div>
    
</body>
</html>
