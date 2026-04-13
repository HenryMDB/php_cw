<div class="add-review-section admin-form-container">
    <h3>🎬 Add New Movie (Admin Zone)</h3>
    
    <form action="" method="POST" enctype="multipart/form-data" class="inline-review-form">
        
        <label for="film_name">Movie Name:</label>
        <input type="text" id="film_name" name="name" required placeholder="Enter movie name...">

        <label for="film_trailer">YouTube Trailer URL (Optional):</label>
        <input type="url" id="film_trailer" name="trailer_url" placeholder="https://www.youtube.com/watch?v=...">

        <label for="film_desc">Film Description (Optional):</label>
        <textarea id="film_desc" name="description" rows="4" placeholder="Enter movie description..."></textarea>

        <div class="form-row">
            <div class="form-col flex-1">
                <label for="film_type">Movie Type:</label>
                <select id="film_type" name="type" required>
                    <option value="">- Select Type -</option>
                    <option value="movie">Movie</option>
                    <option value="series">Series</option>
                </select>
            </div>

            <div class="form-col flex-1">
                <label>Category (Select at least 1):</label>
                
                <div class="checkbox-group">
                    <?php foreach ($categories as $category): ?>
                        <label class="checkbox-item">
                            <input type="checkbox" name="categories_picked[]" value="<?= $category['id'] ?>"><!-- báo name là mảng -->
                            <?= htmlspecialchars($category['category_name']) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <label for="film_dir">Director:</label>
        <input type="text" id="film_dir" name="director" required placeholder="Director's name...">
        
        <label for="film_poster">Poster Image (Required):</label>
        <input type="file" id="film_poster" name="poster" accept="image/*" required>

        <div class="admin-form-actions">
            <button type="submit" name="btn_add_film" class="btn btn-save">💾 Add Movie</button>
            <a href="index.php" class="btn btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>
