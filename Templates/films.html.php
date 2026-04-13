<h2>Movies List</h2>

<form method="GET" action="films.php" class="filter-form scroll-animate">
    <div class="form-group">
        <label>Search by Name:</label>
        <input type="text" name="searchName" value="<?= htmlspecialchars($searchName) ?>" placeholder="Enter film name...">
    </div>
    
    <div class="form-group">
        <label>Type:</label>
        <select name="searchType">
            <option value="">-- All Types --</option>
            <option value="movie" <?= $searchType === 'movie' ? 'selected' : '' ?>>Movie</option>
            <option value="series" <?= $searchType === 'series' ? 'selected' : '' ?>>Series</option>
        </select>
    </div>
    
    <div class="form-group">
        <label>Category:</label>
        <select name="searchCategory">
            <option value="">-- All Categories --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $searchCategory == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-actions" style="display: flex; gap: 10px; height: 45px;">
        <button type="submit" class="btn" style="width: auto; margin-bottom: 0; padding: 0 25px; height: 100%; display: flex; align-items: center;">🔍 Filter</button>
        <?php if (!empty($searchName) || !empty($searchType) || !empty($searchCategory)): ?>
            <a href="films.php" class="btn" style="background-color: #444; color: #fff; text-decoration: none; text-align: center; width: auto; margin-bottom: 0; padding: 0 25px; height: 100%; display: flex; align-items: center;">Reset</a>
        <?php endif; ?>
    </div>
</form>
<div class="list-films">
    <?php foreach ($films as $film): ?>
        <div class="film-card">
            <div class="poster-container">
                <img src="Images/Poster/<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['name']) ?>">
                <span class="film-type"><?= htmlspecialchars(ucfirst($film['type'])) ?></span>
            </div>
            
            <div class="film-info">
                <h3><?= htmlspecialchars($film['name']) ?></h3>
                <p class="category"><?= htmlspecialchars($film['category_name']) ?></p>
                <p class="director"><strong>Director:</strong> <?= htmlspecialchars($film['director']) ?></p>
                
                <form action="reviews.php" method="GET" style="margin-bottom: 10px;">
                    <input type="hidden" name="id" value="<?=$film['id']?>">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <input type="submit" value="View and make Review" class="btn">
                    <?php else: ?>
                        <input type="submit" value="View Review" class="btn">
                    <?php endif;?>
                </form>              

               <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <div class="admin-actions">
                        
                        <a href="admin_edit_film.php?id=<?= $film['id'] ?>" class="btn-admin btn-admin-edit">✏️ Edit</a>

                        <form action="ADMIN_delete_film.php" method="POST" class="form-admin-delete">
                            <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                            <button type="submit" class="btn-admin btn-admin-delete" onclick="return confirm('WARNING: Deleting this movie will also delete all related reviews. Are you sure?');">🗑️ Delete</button>
                        </form>

                    </div>
                <?php endif; ?>
                </div>
        </div>
    <?php endforeach; ?>
</div>