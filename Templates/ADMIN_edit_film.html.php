<div class="add-review-section admin-form-container">
    <h3>✏️ Edit Movie Details: <?= htmlspecialchars($film['name']) ?></h3>

    <div class="current-poster-container">
        <p class="current-poster-label">Current Poster Image:</p>
        <img class="current-poster-img" src="Images/Poster/<?= htmlspecialchars($film['poster']) ?>" alt="Current Poster">
    </div>

    <form action="" method="POST" enctype="multipart/form-data" class="inline-review-form">

        <label>Movie Name:</label>
        <input type="text" name="name" required value="<?= htmlspecialchars($film['name']) ?>" placeholder="Enter movie name...">

        <label>YouTube Trailer URL (Optional):</label>
        <input type="url" name="trailer_url" value="<?= htmlspecialchars($film['trailer_url'] ?? '') ?>" placeholder="https://www.youtube.com/watch?v=...">

        <label>Film Description (Optional):</label>
        <textarea name="description" rows="4" placeholder="Enter movie description..."><?= htmlspecialchars($film['description'] ?? '') ?></textarea>

        <div class="form-row">
            <div class="form-col flex-1">
                <label>Movie Type:</label>
                <select name="type" required>
                    <option value="movie" <?= $film['type'] == 'movie' ? 'selected' : '' ?>>Movie</option>
                    <option value="series" <?= $film['type'] == 'series' ? 'selected' : '' ?>>Series</option>
                </select>
            </div>

            <div class="form-col flex-1">
                <label>Category (Select at least 1):</label>
                <div class="checkbox-group">
                    <?php foreach ($categories as $category): ?>
                        <?php
                            // BƯỚC 1: Dùng if...else để kiểm tra
                            $status = ''; 
                            if (in_array($category['id'], $current_category_ids)) {
                                $status = 'checked';
                            }
                        ?>

                        <label class="checkbox-item">
                            <input type="checkbox" name="categories[]" value="<?= $category['id'] ?>" <?= $status ?>>
                            <?= htmlspecialchars($category['category_name']) ?>
                        </label>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <label>Director:</label>
        <input type="text" name="director" required value="<?= htmlspecialchars($film['director']) ?>" placeholder="Director's name...">

        <label>Upload New Poster (Leave blank if keeping old image):</label>
        <input type="file" name="poster" accept="image/*">

        <div class="admin-form-actions">
            <button type="submit" name="btn_edit_film" class="btn btn-save">💾 Save Changes</button>
            <a href="index.php" class="btn btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>
