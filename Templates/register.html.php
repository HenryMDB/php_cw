<h2 class="section-title">Register</h2>

<form action="register.php" method="POST">
    
    <?php if ($error): ?>
        <div style="color: #ff4d4d; text-align: center; margin-bottom: 20px; font-weight: bold; background: #331111; padding: 10px; border-radius: 5px; border: 1px solid #ff4d4d;">
            ⚠️ <?= $error ?>
        </div>
    <?php endif; ?>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required placeholder="Enter username...">
    
    <label for="firstname">Firstname:</label>
    <input type="text" id="firstname" name="firstname" required placeholder="Enter firstname...">

    <label for="lastname">Lastname:</label>
    <input type="text" id="lastname" name="lastname" required placeholder="Enter lastname...">
    
    <label for="lastname">Email:</label>
    <input type="text" id="email" name="email" required placeholder="Enter your email...">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required placeholder="Enter password...">

    <label for="password_check">Confirm Password:</label>
    <input type="password" id="password_check" name="password_check" required placeholder="Confirm password...">

    <button type="submit" name="btn_register" class="btn">Register</button>
</form>