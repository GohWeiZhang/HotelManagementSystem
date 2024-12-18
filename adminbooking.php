<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Booking Page</title>
    <link rel="stylesheet" href="adminbooking.css">
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

    <main>
        <h1>Booking List</h1>
        <table id="bookingTable">
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Total Price</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                    <th>Booking ID</th>
                    <th>Number of People</th>
                    <th>Action</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <!-- Booking data will be inserted here by JavaScript -->
            </tbody>
        </table>
    </main>

    <script>
        // Function to fetch bookings data
        async function fetchBookings() {
            try {
                const response = await fetch('fetch_bookings.php');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const bookings = await response.json();
                displayBookings(bookings);
            } catch (error) {
                console.error('Error fetching bookings:', error);
                const tableBody = document.querySelector('#bookingTable tbody');
                tableBody.innerHTML = '<tr><td colspan="10">Failed to retrieve bookings.</td></tr>';
            }
        }

        // Function to display bookings in the table
        function displayBookings(bookings) {
            const tableBody = document.querySelector('#bookingTable tbody');
            tableBody.innerHTML = ''; // Clear existing rows
            if (bookings.length > 0) {
                bookings.forEach(row => {
                    const tableRow = `<tr>
                        <td>${row.room_name}</td>
                        <td>${row.checkin_date}</td>
                        <td>${row.checkout_date}</td>
                        <td>${row.total_price}</td>
                        <td>${row.user_name}</td>
                        <td>${row.user_email}</td>
                        <td>${row.user_phone}</td>
                        <td>${row.booking_id}</td>
                        <td>${row.number_of_people}</td>
                        <td><button onclick="deleteBooking(${row.booking_id})">Delete</button></td>
                    </tr>`;
                    tableBody.innerHTML += tableRow;
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="10">No bookings found.</td></tr>';
            }
        }

        // Function to delete a booking
        async function deleteBooking(bookingId) {
            const confirmed = confirm("Are you sure you want to delete this booking?");
            if (confirmed) {
                try {
                    const response = await fetch('delete_booking.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({ booking_id: bookingId })
                    });
                    const result = await response.json();
                    if (result.success) {
                        alert('Booking deleted successfully.');
                        fetchBookings(); // Refresh the bookings list
                    } else {
                        alert('Error deleting booking: ' + result.error);
                    }
                } catch (error) {
                    console.error('Error deleting booking:', error);
                    alert('An error occurred while deleting the booking.');
                }
            }
        }

        // Fetch bookings when the page loads
        window.onload = fetchBookings;
    </script>
</body>

</html>
