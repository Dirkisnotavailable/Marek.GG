<?php
require_once '../Library/sessionstart.php';
require_once '../Library/database.php';
require_once './adminfunctions.php';
require_once '../CSS/designfunctions.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['success']))
{
    switch ($_GET['success']) {
        case 1:
            echo ' <script> alert("Streamer added successfully.") </script>';
            break;
        case 2:
            echo ' <script> alert("Streamer removed successfully.") </script>';
            break;
    }
}

if (isset($_GET['failure']))
{
    switch ($_GET['failure']) {
        case 1:
            echo ' <script> alert("This streamer is not an added streamer. So you cant remove him!") </script>';
            break;
        case 2:
            echo ' <script> alert("This streamer is already added!") </script>';
            break;
        case 3:
            echo ' <script> alert("This streamer doesnt exist!") </script>';
            break;
    }

}
renderNavbar(); 
rendersidebar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./streamers.css">
    <title>Marek.GG - Admin panel</title>
</head>
<body>
    <div class="admin-container">
        <div class="main-content">
            <h2>Streamer dashboard</h2>
            <div class="button-container">
                <button onclick="toggleFormadd()" class="addstreamerbutton">Add Streamer</button>
                <button onclick="toggleFormremove()" class="removestreamerbutton">Remove streamer</button>
            </div>
            <?php showStreamerCards(); ?>
        </div>
    </div>
    <div class="streamertable">
        <?php showstreamers(); ?>
    </div>
    <div id="editForm" class="edit-form">
        <h2>Edit Streamer</h2>
        <form id="edit-user-form">
            <label for="edit-field">Edit to:</label>
            <input type="text" id="edit-field" name="edit-field" required>
            <button type="submit">Save</button>
        </form>
    </div>
    <div id="streamerForm" class="overlay-form">
        <form action="addstreamerprocess_form.php" method="POST">
            <label for="streamerName">Streamer Name:</label>
            <input type="text" id="streamerName" name="streamerName" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="Entertainer">Entertainer</option>
                <option value="Support">Support</option>
                <option value="ADC">ADC</option>
                <option value="Mid">Mid</option>
                <option value="Jungle">Jungle</option>
                <option value="Top">Top</option>
            </select>
            <button type="submit">Add streamer!</button>
        </form>
    </div>
    <div id="removestreamerForm" class="overlay-form">
        <form action="removestreamerprocess_form.php" method="POST">
            <label for="streamerName">Streamer Name:</label>
            <input type="text" id="streamerName" name="streamerName" required>
            <button type="submit">Remove streamer!</button>
        </form>
    </div>
    <div id="changeRoleForm" class="overlay-form">
        <form id="change-role-form">
            <label for="newRole">New Role:</label>
            <select id="newRole" name="newRole" required>
                <option value="Entertainer">Entertainer</option>
                <option value="Support">Support</option>
                <option value="ADC">ADC</option>
                <option value="Mid">Mid</option>
                <option value="Jungle">Jungle</option>
                <option value="Top">Top</option>
            </select>
            <button type="submit">Change Role</button>
        </form>
    </div>
    <script src="./adminpanel.js"></script>
    <script type="text/javascript">
        function toggleFormadd() {
            var form = document.getElementById('streamerForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        function toggleFormremove() {
            var form = document.getElementById('removestreamerForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('streamerForm').style.display = 'none';
            document.getElementById('removestreamerForm').style.display = 'none';
            document.getElementById('changeRoleForm').style.display = 'none';
        });

        document.addEventListener('click', function(event) {
            const streamerForm = document.getElementById('streamerForm');
            const removestreamerForm = document.getElementById('removestreamerForm');
            const changeRoleForm = document.getElementById('changeRoleForm');
            if (streamerForm.style.display === 'block' && !streamerForm.contains(event.target) && event.target !== document.querySelector('.addstreamerbutton')) {
                streamerForm.style.display = 'none';
            }
            if (removestreamerForm.style.display === 'block' && !removestreamerForm.contains(event.target) && event.target !== document.querySelector('.removestreamerbutton')) {
                removestreamerForm.style.display = 'none';
            }
            if (changeRoleForm.style.display === 'block' && !changeRoleForm.contains(event.target) && event.target !== document.querySelector('#changeRole')) {
                changeRoleForm.style.display = 'none';
            }
        });

        document.getElementById('changeRole').addEventListener('click', function() {
            const changeRoleForm = document.getElementById('changeRoleForm');
            changeRoleForm.style.display = 'block';
        });

        document.getElementById('change-role-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const streamerId = document.getElementById('cardOptions').dataset.streamerId;
            const newRole = document.getElementById('newRole').value;
            fetch('/Testik/adminpanel/updatestreamer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ streamerId: streamerId, column: 'role', newValue: newRole })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Role updated successfully');
                    location.reload();
                } else {
                    alert('Error updating role: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating role.');
            });
        });
    </script>
</body>
<footer>
</footer>
</html>