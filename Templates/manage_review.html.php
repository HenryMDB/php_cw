<h1 class="page-title">Manage reviews of: <?= htmlspecialchars($_SESSION['username']) ?></h1>

<div class="manage-reviews-container">
    <?php foreach ($user_reviews as $user_review): ?>
        <div class="review-item">
            
            <div class="review-header">
                <h3 class="film-name">Movie: <?= htmlspecialchars($user_review['film_name']) ?></h3>
                <div class="rating">⭐ <?= htmlspecialchars($user_review['rating']) ?>/10</div>
            </div>
            
            <div class="detail">"<?= htmlspecialchars($user_review['detail']) ?>"</div>
            
            <?php if (!empty($user_review['screenshot'])): ?>
                <div class="screenshot-wrapper">
                    <img src="Images/Screenshot/<?= htmlspecialchars($user_review['screenshot']) ?>" alt="Screenshot">
                </div>
            <?php endif; ?>
            
            <div class="comment-time">Posted at: <?= htmlspecialchars($user_review['created_at']) ?></div>
            
            <div class="action-buttons">
                <a href="edit_review.php?id=<?= $user_review['id'] ?>" class="btn-action btn-edit">✏️ Edit</a>

                <form action="" method="POST" class="delete-form">
                    <input type="hidden" name="review_id_to_delete" value="<?= $user_review['id'] ?>">
                    <button type="submit" name="btn_delete_review" class="btn-action btn-delete" onclick="return confirm('Are you sure you want to delete this review? This action cannot be undone!');">🗑️ Delete</button>
                </form>
            </div>
            
        </div>
    <?php endforeach; ?>
</div> 