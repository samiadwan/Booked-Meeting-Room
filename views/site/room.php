<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Room Booking List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-room">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Add a form for inserting data -->
    <form id="roomForm">
        <input type="hidden" id="roomId" name="roomId">
        <label for="roomName">Room Name:</label>
        <input type="text" id="roomName" name="roomName" required>
        <label for="roomStatus">Status:</label>
        <select id="roomStatus" name="roomStatus" required>
            <option value="available">Available</option>
            <option value="booked">Booked</option>
            <option value="maintenance">Maintenance</option>
        </select>
        <button type="button" id="saveRoomButton">Save Room</button>
        <button type="button" id="updateRoomButton" style="display: none;">Update Room</button>
    </form>

    <style>
        /* Add CSS styles here */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
        
    </style>

    <h2>Room List</h2>

    <table id="roomTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be dynamically added here -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const apiUrl = 'http://localhost:8080/v1/room';
            const apiUrlCreate = 'http://localhost:8080/v1/room/create';
            const apiUrlUpdate = 'http://localhost:8080/v1/room/update';
            const apiUrlDelete = 'http://localhost:8080/v1/room/delete';
            const bearerToken = 'w53UWAzwgE9W5C3ajSjgb3qY4Xcix4Nr';

            const requestOptions = {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${bearerToken}`,
                    'Content-Type': 'application/json'
                }
            };

            fetch(apiUrl, requestOptions)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    displayRoomData(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            function displayRoomData(data) {
                const tableBody = document.querySelector('#roomTable tbody');
                tableBody.innerHTML = '';
                data.forEach(room => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${room.id}</td>
                        <td>${room.room_name}</td>
                        <td>${room.status}</td>
                        <td>
                            <button onclick="editRoom(${room.id}, '${room.room_name}', '${room.status}')">Edit</button>
                            <button onclick="deleteRoom(${room.id})">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            document.getElementById('saveRoomButton').addEventListener('click', function () {
                const roomName = document.getElementById('roomName').value;
                const roomStatus = document.getElementById('roomStatus').value;

                const roomData = {
                    room_name: roomName,
                    status: roomStatus
                };

                const requestOptions = {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(roomData)
                };

                fetch(apiUrlCreate, requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to save room: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Room saved successfully:', data);
                        document.getElementById('roomForm').reset();
                        fetch(apiUrl, {
                            method: 'GET',
                            headers: {
                                'Authorization': `Bearer ${bearerToken}`,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            displayRoomData(data);
                        })
                        .catch(error => {
                            console.error('Error refreshing room list:', error);
                        });
                    })
                    .catch(error => {
                        console.error('Error saving room:', error);
                    });
            });

            document.getElementById('updateRoomButton').addEventListener('click', function () {
                const roomId = document.getElementById('roomId').value;
                const roomName = document.getElementById('roomName').value;
                const roomStatus = document.getElementById('roomStatus').value;

                const roomData = {
                    room_name: roomName,
                    status: roomStatus
                };

                const requestOptions = {
                    method: 'PATCH',
                    headers: {
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(roomData)
                };

                fetch(`${apiUrlUpdate}?id=${roomId}`, requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to update room: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Room updated successfully:', data);
                        document.getElementById('roomForm').reset();
                        document.getElementById('saveRoomButton').style.display = 'inline';
                        document.getElementById('updateRoomButton').style.display = 'none';
                        fetch(apiUrl, {
                            method: 'GET',
                            headers: {
                                'Authorization': `Bearer ${bearerToken}`,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            displayRoomData(data);
                        })
                        .catch(error => {
                            console.error('Error refreshing room list:', error);
                        });
                    })
                    .catch(error => {
                        console.error('Error updating room:', error);
                    });
            });
        });

        function editRoom(id, name, status) {
            document.getElementById('roomId').value = id;
            document.getElementById('roomName').value = name;
            document.getElementById('roomStatus').value = status;
            document.getElementById('saveRoomButton').style.display = 'none';
            document.getElementById('updateRoomButton').style.display = 'inline';
        }

        function deleteRoom(id) {
    const apiUrlDelete = `http://localhost:8080/v1/room/delete`;
    const bearerToken = 'w53UWAzwgE9W5C3ajSjgb3qY4Xcix4Nr';
    const apiUrl = 'http://localhost:8080/v1/room';
    const requestOptions = {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${bearerToken}`,
            'Content-Type': 'application/json'
        }
    };

    fetch(`${apiUrlDelete}?id=${id}`, requestOptions)
        .then(response => {
            if (response.status === 204) {
                // Room deleted successfully
                console.log('Room deleted successfully');
                // Refresh the room list
                fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${bearerToken}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    displayRoomData(data);
                })
                .catch(error => {
                    console.error('Error refreshing room list:', error);
                });
            } else if (!response.ok) {
                throw new Error('Failed to delete room: ' + response.statusText);
            }
        })
        .catch(error => {
            console.error('Error deleting room:', error);
        });

    // Define the displayRoomData function here
    function displayRoomData(data) {
        const tableBody = document.querySelector('#roomTable tbody');
        tableBody.innerHTML = '';
        data.forEach(room => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${room.id}</td>
                <td>${room.room_name}</td>
                <td>${room.status}</td>
                <td>
                    <button onclick="editRoom(${room.id}, '${room.room_name}', '${room.status}')">Edit</button>
                    <button onclick="deleteRoom(${room.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }
}

    </script>

</div>
