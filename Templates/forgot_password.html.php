<div class="add-review-section admin-form-container forgot-pwd-container">
    <h3 class="forgot-pwd-title">Recover Password</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="inline-review-form">
        
        <?php if ($step === 1): ?>
            <p class="forgot-pwd-desc">Enter Email to receive verification code.</p>
            <input type="email" name="email" required placeholder="Enter your email...">
            <button type="submit" name="btn_send_otp" class="btn btn-save btn-full-width">📩 Send OTP Code</button>

        <?php elseif ($step === 2): ?>
            <p class="forgot-pwd-desc">A 6-digit code has been sent to: <br><strong class="highlight-text"><?= htmlspecialchars($_SESSION['reset_email']) ?></strong></p>
            
            <input type="number" name="otp_input" required placeholder="Enter 6-digit code..." class="otp-input">
            
            <div class="otp-actions">
                <button type="submit" name="btn_verify_otp" class="btn btn-save">Confirm</button>
                <button type="submit" name="btn_cancel" class="btn btn-cancel" formnovalidate>Cancel / Edit Email</button>
            </div>

        <?php elseif ($step === 3): ?>
            <p class="forgot-pwd-desc">Create a new password for your account.</p>
            <input type="password" name="new_password" required placeholder="New password...">
            <input type="password" name="confirm_password" required placeholder="Confirm new password...">
            
            <button type="submit" name="btn_reset" class="btn btn-save btn-full-width">💾 Save & Login</button>

        <?php endif; ?>

    </form>

</div>