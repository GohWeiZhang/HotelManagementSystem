<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="adminhomepage.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <div class="main">
        <div class="card">
            <img src="client.jpg" alt="Image representing total registered people" class="card-image">
            <div class="registered-info">
                <p>Total Registered People: <span id="registered-count"></span></p>
            </div>
        </div>

        <div class="card">
            <img src="feedback.jpg" alt="Image representing total feedback received" class="card-image">
            <div class="registered-info">
                <p>Total Feedback Received: <span id="feedback-count"></span></p>
            </div>
        </div>

        <div class="card">
            <img src="money.jpg" alt="Image representing total money earned" class="card-image">
            <div class="registered-info">
                <p>Total Money Earned: RM <span id="total-money-earned"></span></p>
            </div>
        </div>

<!-- Flex container for both charts -->
<div class="chart-row">
    <!-- Chart Container for Room Booking Quantities -->
    <div class="chart-container white-container">
        <canvas id="quantityChart" width="400" height="200"></canvas>
    </div>

    <!-- Chart Container for People Booking Counts -->
    <div class="chart-container white-container">
        <canvas id="peopleBookingChart" width="400" height="200"></canvas>
    </div>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function fetchRegisteredCount() {
                fetch('processclient.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('registered-count').textContent = data.registered_count;
                    })
                    .catch(error => console.error('Error fetching registered count:', error));
            }

            function fetchFeedbackCount() {
                fetch('processtotalfeedback.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('feedback-count').textContent = data.feedback_count;
                    })
                    .catch(error => console.error('Error fetching feedback count:', error));
            }

            function fetchTotalEarnings() {
                fetch('processTotalEarning.php')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('total-money-earned').textContent = parseFloat(data.total_earnings).toFixed(2);
                    })
                    .catch(error => console.error('Error fetching total earnings:', error));
            }

            function fetchQuantityData() {
                fetch('processRoomQuantities.php')
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.room_name);
                        const quantities = data.map(item => item.booking_count);

                        const ctx = document.getElementById('quantityChart').getContext('2d');
                        const quantityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Quantity of Bookings per Room',
                                    data: quantities,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of Bookings'
                                        },
                                        ticks: {
                                            stepSize: 1
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Room Names'
                                        }
                                    }
                                },
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    }
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching quantity data:', error));
            }

            function fetchPeopleBookingData() {
    fetch('processBookingCounts.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.number_of_people + ' Person' + (item.number_of_people > 1 ? 's' : ''));
            const bookingCounts = data.map(item => item.booking_count);

            const ctx = document.getElementById('peopleBookingChart').getContext('2d');
            const peopleBookingChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Number of Bookings by Number of People',
                        data: bookingCounts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Bookings'
                            },
                            ticks: {
                                stepSize: 1 // Set the step size for the Y-axis ticks
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Number of People'
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching booking counts:', error));
}


            // Fetch data when the page loads
            fetchRegisteredCount();
            fetchFeedbackCount();
            fetchTotalEarnings();
            fetchQuantityData();
            fetchPeopleBookingData();
        });
    </script>
</body>

</html>
