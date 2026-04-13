<div class="add-review-section admin-form-container">
    <h3>👤 My Profile</h3>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="inline-review-form">
        
        <label>Username (Cannot be changed):</label>
        <input type="text" class="input-readonly" value="@<?= htmlspecialchars($user['username']) ?>" readonly>

        <div class="form-row">
            <div class="form-col flex-1">
                <label>First Name:</label>
                <input type="text" name="firstname" required value="<?= htmlspecialchars($user['firstname']) ?>">
            </div>
            <div class="form-col flex-1">
                <label>Last Name:</label>
                <input type="text" name="lastname" required value="<?= htmlspecialchars($user['lastname']) ?>">
            </div>
        </div>

        <label>Email Address:</label>
        <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>">

        <hr class="profile-divider">
        <h4 class="profile-subtitle">Change Password (Leave blank to keep current)</h4>

        <div class="form-row">
            <div class="form-col flex-1">
                <label>New Password:</label>
                <input type="password" name="new_password" placeholder="Enter new password...">
            </div>
            <div class="form-col flex-1">
                <label>Confirm New Password:</label>
                <input type="password" name="confirm_password" placeholder="Re-enter new password...">
            </div>
        </div>

        <div class="admin-form-actions">
            <button type="submit" name="btn_update" class="btn btn-save">💾 Update Profile</button>
            <a href="index.php" class="btn btn-cancel">❌ Go Back</a>
        </div>
    </form>
</div>