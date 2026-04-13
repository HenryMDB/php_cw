<h2><?= htmlspecialchars($film['name']) ?></h2>

<div class="film-review">
    <div class="film-poster-col">
        <img src="Images/Poster/<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['name']) ?> Movie Poster">
        <span class="film-type" style="margin-top: 15px; font-size: 1.2rem; display: inline-block; padding: 5px 15px; background: #222; border: 1px solid #f5c518; border-radius: 20px;">
            ⭐ <?= $average_rating > 0 ? $average_rating : 'N/A' ?>/10 <span style="font-size: 0.9rem; color: #aaa;">(<?= count($reviews) ?> reviews)</span>
        </span>
    </div>

    <div class="review-box">
        
        <?php 
        $youtube_id = '';
        if (!empty($film['trailer_url'])) {
            // Regex to extract video ID from standard Youtube links, youtu.be, and embed URLs
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $film['trailer_url'], $match)) {
                $youtube_id = $match[1];
            }
        }
        ?>
        <?php if ($youtube_id): ?>
            <div class="film-trailer-box scroll-animate" style="margin-bottom: 30px;">
                <h3 style="color:#f5c518; margin-top:0; border-bottom: 1px solid #333; padding-bottom:10px; margin-bottom:15px;">🎬 Official Trailer</h3>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px; background:#000; box-shadow: 0 8px 20px rgba(0,0,0,0.8); border: 2px solid #333;">
                    <iframe title="YouTube Video Trailer for <?= htmlspecialchars($film['name']) ?>" src="https://www.youtube.com/embed/<?= $youtube_id ?>?rel=0" 
                            style="position: absolute; top:0; left: 0; width: 100%; height: 100%; border: none;" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($film['description'])): ?>
            <div class="film-description-box scroll-animate" style="background:#1e1e1e; padding: 20px; border-radius:10px; margin-bottom:30px; box-shadow: 0 8px 20px rgba(0,0,0,0.6);">
                <h3 style="color:#f5c518; margin-top:0; border-bottom: 1px solid #333; padding-bottom:10px; margin-bottom:10px;">📖 Synopsis</h3>
                <p style="color:#ddd; line-height:1.6; white-space: pre-line;"><?= htmlspecialchars($film['description']) ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="add-review-section">
                <h3>Write your review</h3>
                <form action="add_review.php" method="POST" enctype="multipart/form-data" class="inline-review-form">
                    <input type="hidden" name="film_id" value="<?= htmlspecialchars($id) ?>">
                    <label for="review_detail">Your thoughts:</label>
                    <textarea id="review_detail" name="detail" rows="4" required placeholder="How is this movie?..."></textarea>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <label for="review_rating">Rating (1-10):</label>
                            <select id="review_rating" name="rating" required>
                                <option value="">-- Select rating --</option>
                                <option value="10">10 - Masterpiece</option>
                                <option value="9">9 - Excellent</option>
                                <option value="8">8 - Very Good</option>
                                <option value="7">7 - Good</option>
                                <option value="6">6 - Decent</option>
                                <option value="5">5 - Average</option>
                                <option value="4">4 - Bad</option>
                                <option value="3">3 - Very Bad</option>
                                <option value="2">2 - Disaster</option>
                                <option value="1">1 - Unwatchable</option>
                            </select>
                        </div>

                        <div class="form-col">
                            <label for="review_screenshot">Attach Screenshot (Optional):</label>
                            <input type="file" id="review_screenshot" name="screenshot" accept="image/*">
                        </div>
                    </div>

                    
                    <button type="submit" name="btn_add_review" class="btn">Post Review</button>
                </form>
            </div>
        <?php else: ?>
            <div class="login-prompt">
                <p>Please <a href="login.php">Login</a> or <a href="register.php">Register</a> to write a review for this movie.</p>
            </div>
        <?php endif; ?>
<!-- ################################################################################################# -->
        <?php if (!empty($reviews)): ?>
            <h3 class="scroll-animate" style="color: #f5c518; border-bottom: 1px solid #333; padding-bottom: 10px; margin-top: 40px; margin-bottom: 20px;">💬 All Reviews</h3>
        <?php endif; ?>

        <?php foreach ($reviews as $review): ?>
            <div class="review-item">
                <?php if ($review['role'] == 'admin'): ?>
                    <h3>👑 <?= htmlspecialchars($review['firstname']) . " " . htmlspecialchars($review['lastname']) .' (Admin)' ?></h3>
                <?php else: ?>
                     <h3>👤 <?= htmlspecialchars($review['firstname']) . " " . htmlspecialchars($review['lastname']) ?></h3>
                <?php endif; ?>
                <div class="rating">⭐ <?= htmlspecialchars($review['rating']) ?>/10</div>
                <div class="detail">"<?= htmlspecialchars($review['detail']) ?>"</div>
                
                <?php if (!empty($review['screenshot'])): ?>
                    <img src="Images/Screenshot/<?= htmlspecialchars($review['screenshot']) ?>" alt="Screenshot">
                <?php endif; ?>
                
                <div class="comment-time">Posted at: <?= htmlspecialchars($review['created_at']) ?></div>
            </div>
        <?php endforeach; ?>