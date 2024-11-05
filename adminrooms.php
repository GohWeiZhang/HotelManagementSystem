<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Room Page</title>
    <link rel="stylesheet" href="adminroom.css">
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
        <h1>Room Management</h1> 
        <form id="roomForm" enctype="multipart/form-data">
            <input type="hidden" id="roomId" name="id">
            <label for="name">Room Name:</label>
            <input type="text" id="name" name="name" required><br>
    
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br>
    
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>
    
            <label for="image">Room Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
    
            <button type="submit">Save Room</button>
        </form>
        
        <h2>Room List</h2>
        <div id="roomList"></div>
    
        <script src="admin_room.js"></script>
  
</body>

</html>
