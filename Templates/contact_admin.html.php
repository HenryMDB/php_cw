<?php if (isset($_SESSION['user_id'])): ?>
    <form action="contact_admin.php" method="POST">
        <div>
            <label for="message">Enter your message:</label>
        </div>
        <div>
            <textarea id="message" name="message" rows="4" required placeholder="Type your message..."></textarea>
        </div>
        <div>
            <button type="submit" name="btn_send_email">Send Message</button>
        </div>
    </form>
<?php endif; ?>