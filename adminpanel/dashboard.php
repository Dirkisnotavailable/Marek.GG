<?php
require_once '../Library/sessionstart.php';
require_once '../Library/database.php';
require_once './adminfunctions.php';
require_once '../CSS/designfunctions.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

// Retrieve the number of searches
$numberOfSearches = getNumberofSearches();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Marek.GG - Admin panel</title>
</head>
<body>
    <?php
    renderNavbar(); 
    rendersidebar();
    ?>
    <div class="admin-container">
        <div class="main-content">
            <h1>Admin Dashboard</h1>
            <div class="dashboard-cards">
                <div class="card">
                    <i class="fas fa-users"></i>
                    <h2>Total Users</h2>
                    <p><?php echo getTotalUsers(); ?></p>
                </div>
                <div class="card">
                    <i class="fas fa-video"></i>
                    <h2>Total Streamers</h2>
                    <p><?php echo getTotalStreamers(); ?></p>
                </div>
                <div class="card">
                    <i class="fas fa-user-plus"></i>
                    <h2>New Users This Month</h2>
                    <p><?php echo getNewUsersThisMonth(); ?></p>
    </div>
    <script src="./adminpanel.js"></script>
</body>
<footer>
</footer>
</html>