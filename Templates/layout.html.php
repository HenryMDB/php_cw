<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="reviewfilm.css">
    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
        <link rel="stylesheet" href="reviewfilm_admin.css">
    <?php endif; ?>  
    <title>Review Film</title>
</head>
<body>
    <div class="page-transition-overlay"></div>
    <header class="cinematic-header">
        <canvas id="rainCanvas" aria-hidden="true"></canvas>
        <div class="header-content">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
                <h1>Review Film System <span class="admin-badge">Admin</span></h1>
            <?php else: ?>
                <h1>Review Film System</h1>
            <?php endif; ?>
        </div>      
    </header>
    <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="films.php">Movies</a></li>
        <!-- <li><a href="reviews.php">All Reviews</a></li> -->

        <?php if (isset($_SESSION['user_id'])): ?>
            
            <li><a href="manage_review.php">Manage My Review</a></li>

            <?php if ($_SESSION['role'] == 'admin'): ?>
                <li><a href="admin_add_film.php">Add Movies</a></li>
                <li><a href="ADMIN_manage_users.php">Manage Users</a></li>
                <li><a href="edit_profile.php">Manage Account</a></li>
            <?php else: ?>
                <li><a href="edit_profile.php">Manage Account</a></li>
                <li><a href="contact_admin.php">Contact Admin</a></li>
            <?php endif; ?>

            

            <li><a href="logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>

        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>
</nav>

    <main>
        <?=$output?>
    </main>
    <script src="main.js"></script>
</body>
</html>