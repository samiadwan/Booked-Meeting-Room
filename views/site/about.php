<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Room';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

   

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

    <!-- <h2>Room Data</h2> -->

    <table id="roomTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be dynamically added here -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Define the API endpoint
            const apiUrl = 'http://localhost:8080/v1/room';
            // Define the Bearer token
            const bearerToken = 'w53UWAzwgE9W5C3ajSjgb3qY4Xcix4Nr';

            // Define the request options
            const requestOptions = {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${bearerToken}`,
                    'Content-Type': 'application/json'
                }
            };

            // Fetch data from the API
            fetch(apiUrl, requestOptions)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    // Handle the data
                    displayRoomData(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            // Function to display room data in the table
            function displayRoomData(data) {
                const tableBody = document.querySelector('#roomTable tbody');
                data.forEach(room => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${room.id}</td>
                        <td>${room.room_name}</td>
                        <td>${room.status}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        });
    </script>
    <!-- <code><?= __FILE__ ?></code> -->
</div>
