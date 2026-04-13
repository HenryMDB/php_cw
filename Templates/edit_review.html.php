<div class="add-review-section" style="max-width: 800px; margin: 0 auto;">
    <h3>✏️ Edit movie review: <?= htmlspecialchars($review['film_name']) ?></h3>
    
    <form action="" method="POST" enctype="multipart/form-data" class="inline-review-form">
        <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
        <input type="hidden" name="screenshot" value="<?= htmlspecialchars($review['screenshot']) ?>">

        <label>Your Thoughts:</label>
        <textarea name="detail" rows="4" required><?= htmlspecialchars($review['detail']) ?></textarea>

        <div class="form-row">
            <div class="form-col rating-col">
                <label>Rating:</label>
                <select name="rating" required>
                    <?php for ($i = 10; $i >= 1; $i--): ?>
                        <option value="<?= $i ?>" <?= ($i == $review['rating']) ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-col screenshot-col">
                <label>Change image (Leave blank to keep old image):</label>
                <input type="file" name="screenshot" accept="image/*">
            </div>
        </div>

        <?php if (!empty($review['screenshot'])): ?>
            <div style="margin-bottom: 20px;">
                <label>Current Image:</label>
                <img src="Images/Screenshot/<?= htmlspecialchars($review['screenshot']) ?>" style="max-height: 150px; border-radius: 8px; border: 1px solid #444;">
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 15px; margin-top: 20px;">
            <button type="submit" name="btn_update_review" class="btn" style="flex: 1;">Save Changes</button>
            <a href="manage_review.php" class="btn" style="flex: 1; background-color: #555; text-align: center; text-decoration: none;">Cancel</a>
        </div>
    </form>
</div>