document.addEventListener('DOMContentLoaded', function() {
    const roomForm = document.getElementById('roomForm');
    const roomList = document.getElementById('roomList');

    // Fetch existing rooms
    fetchRooms();

    // Submit form (Add or Edit)
    roomForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(roomForm);
        const id = formData.get('id');
        
        if (id) {
            // Edit existing room
            fetch('process_room.php?action=edit', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                fetchRooms();
                roomForm.reset();
            });
        } else {
            // Add new room
            fetch('process_room.php?action=add', {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(data => {
                fetchRooms();
                roomForm.reset();
            });
        }
    });

    // Fetch rooms
    function fetchRooms() {
        fetch('process_room.php?action=list')
            .then(response => response.json())
            .then(data => {
                roomList.innerHTML = '';
                data.forEach(room => {
                    roomList.innerHTML += `
                        <div class="room-item">
                            <strong>${room.name}</strong> - $${room.price}<br>
                            ${room.description}<br>
                            <img src="uploads/${room.image}" alt="Room Image"><br>
                            <button onclick="editRoom(${room.id})">Edit</button>
                            <button onclick="deleteRoom(${room.id})">Delete</button>
                        </div>
                    `;
                });
            });
    }

    // Edit room
    window.editRoom = function(id) {
        fetch(`process_room.php?action=get&id=${id}`)
            .then(response => response.json())
            .then(room => {
                document.getElementById('roomId').value = room.id;
                document.getElementById('name').value = room.name;
                document.getElementById('price').value = room.price;
                document.getElementById('description').value = room.description;
            });
    };

    // Delete room
    window.deleteRoom = function(id) {
        if (confirm('Are you sure you want to delete this room?')) {
            fetch(`process_room.php?action=delete&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    fetchRooms();
                });
        }
    };
});
