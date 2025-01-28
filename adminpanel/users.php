<?php
require_once '../Library/sessionstart.php';
require_once '../Library/database.php';
require_once './adminfunctions.php';
require_once '../CSS/designfunctions.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['success'])) {

    switch ($_GET['success']) {
        case '1':
            echo '<script>alert("User added successfully!")</script>';
            break;
        case '2':
            echo '<script>alert("User removed successfully!")</script>';
            break;
    }
}

if (isset($_GET['failure'])) {
    switch ($_GET['failure']) {
        case '1':
            echo '<script>alert("User does not exist!")</script>';
            break;
        case '2':
            echo '<script>alert("User with that nickname or email already exists!")</script>';
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
    <link rel="stylesheet" href="./users.css">
    <title>Marek.GG - Admin panel</title>
</head>
<body>
    <div class="admin-container">
        <div class="main-content">
            <h2>User dashboard</h2>
            <div class="button-container">
                <button onclick="toggleFormadd()" class="adduserbutton">Add User</button>
                <button onclick="toggleFormremove()" class="removeuserbutton">Remove User</button>
            </div>
            <?php showUserCards(); ?>
        </div>
    </div>
    <div class="usertable">
        <?php showUsers(); ?>
    </div>
    <div id="editForm" class="edit-form">
        <h2>Edit User</h2>
        <form id="edit-user-form">
            <label for="edit-field">Edit to:</label>
            <input type="text" id="edit-field" name="edit-field" required>
            <button type="submit">Save</button>
        </form>
    </div>
    <div id="userForm" class="overlay-form">
        <form action="adduserprocess_form.php" method="POST">
            <label for="nickname">User Name:</label>
            <input type="text" id="nickname" name="nickname" required>
            <input type="password" id="password" name="password" required>
            <input type="email" id="email" name="email" required>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="Admin">Admin</option>
                <option value="Moderator">Moderator</option>
                <option value="User">User</option>
            </select>
            <button type="submit">Add User!</button>
        </form>
    </div>
    <div id="removeuserForm" class="overlay-form">
        <form action="removeuserprocess_form.php" method="POST">
            <label for="nickname">User Name:</label>
            <input type="text" id="nickname" name="nickname" required>
            <button type="submit">Remove User!</button>
        </form>
    </div>
    <script src="./adminpanel.js"></script>
    <script type="text/javascript">
        function toggleFormadd() {
            var form = document.getElementById('userForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        function toggleFormremove() {
            var form = document.getElementById('removeuserForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('userForm').style.display = 'none';
            document.getElementById('removeuserForm').style.display = 'none';
        });

        document.addEventListener('click', function(event) {
            const userForm = document.getElementById('userForm');
            const removeuserForm = document.getElementById('removeuserForm');
            if (userForm.style.display === 'block' && !userForm.contains(event.target) && event.target !== document.querySelector('.adduserbutton')) {
                userForm.style.display = 'none';
            }
            if (removeuserForm.style.display === 'block' && !removeuserForm.contains(event.target) && event.target !== document.querySelector('.removeuserbutton')) {
                removeuserForm.style.display = 'none';
            }
        });
    </script>
</body>
<footer>
</footer>
</html>