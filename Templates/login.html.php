<h2 class="section-title">Login</h2>

<form action="login.php" method="POST">
    
    <?php if ($error): ?>
        <div style="color: #ff4d4d; text-align: center; margin-bottom: 20px; font-weight: bold; background: #331111; padding: 10px; border-radius: 5px; border: 1px solid #ff4d4d;">
            ⚠️ <?= $error ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_msg'])): ?>
        <div style="color: #059c00; text-align: center; margin-bottom: 20px; font-weight: bold; background: #004c78; padding: 10px; border-radius: 5px; border: 1px solid #ff4d4d;">
            ✅ <?= $_SESSION['success_msg'] ?>
        </div>
        <?php unset($_SESSION['success_msg']); ?>
    <?php endif; ?>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required placeholder="Enter username...">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter password...">

    <button type="submit" name="btn_login" class="btn">Login</button>
    <a href="register.php">Don't have an account? Register</a>
    <br></br>
    <a href="forgot_password.php">Forgot password?</a>
</form>