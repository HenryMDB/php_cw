<h2 class="section-title">🌟 Top 5 Newly Added Movies 🌟</h2>
<div class="carousel-container scroll-animate">
    <div class="carousel-track" id="carouselTrack">
        
        <?php foreach ($films as $index => $film): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="poster-wrapper">
                    <img src="Images/Poster/<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['name']) ?>">
                    <div class="poster-overlay">
                        <a href="reviews.php?id=<?= $film['id'] ?>" class="btn-hover-review">View Review</a>
                    </div>
                </div>
                
                <div class="carousel-info">
                    <h3><?= htmlspecialchars($film['name']) ?></h3>
                    <p>Director: <?= htmlspecialchars($film['director']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="home-bottom-layout">
    <!-- LATEST REVIEWS (LEFT) -->
    <div class="home-reviews-section">
        <h2 class="section-title" style="text-align: left; margin-top: 0;">💬 Latest Reviews</h2>
        <div class="latest-reviews-container">
            <?php foreach($latest_reviews as $rev): ?>
                <div class="latest-review-card scroll-animate">
                    <div class="latest-review-header">
                        <h4>@<?= htmlspecialchars($rev['username']) ?> <span>on</span> <?= htmlspecialchars($rev['film_name']) ?></h4>
                        <div class="latest-review-rating"><?= htmlspecialchars($rev['rating']) ?>/10</div>
                    </div>
                    <?php 
                        $short_detail = mb_strlen($rev['detail']) > 120 
                                        ? mb_substr($rev['detail'], 0, 120) . '...' 
                                        : $rev['detail'];
                    ?>
                    <p class="latest-review-detail">"<?= htmlspecialchars($short_detail) ?>"</p>
                    <p class="latest-review-time"><?= date('d M Y, H:i', strtotime($rev['created_at'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CÁC THỐNG KÊ (RIGHT) -->
    <div class="home-stats-section">
        <h2 class="section-title" style="margin-top: 0;">📊 Statistics</h2>
        <div class="stats-container">
            <div class="stat-box scroll-animate">
                <h3><?= $total_films ?></h3>
                <p>Total Movies</p>
            </div>
            <div class="stat-box scroll-animate">
                <h3><?= $total_reviews ?></h3>
                <p>Total Reviews</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const track = document.getElementById('carouselTrack');
        const items = document.querySelectorAll('.carousel-item');
        const container = document.querySelector('.carousel-container');
        if (items.length === 0) return;

        let currentIndex = 0;
        let slideInterval;
        function updateCarousel() {
            // 1. Remove 'active' class from all movies
            items.forEach(item => item.classList.remove('active'));
            
            // 2. Add 'active' class to the current movie
            items[currentIndex].classList.add('active');

            // 3. Calculate distance to push the 'active' movie to the exact center
            const containerWidth = track.parentElement.offsetWidth;
            const itemWidth = items[currentIndex].offsetWidth;
            const itemOffset = items[currentIndex].offsetLeft;
            const centerPosition = (containerWidth / 2) - itemOffset - (itemWidth / 2);

            // 4. Apply translate command
            track.style.transform = `translateX(${centerPosition}px)`;
        }

        // Run for the first time when web is loaded
        updateCarousel();

        // Update center position if user resizes browser window
        window.addEventListener('resize', updateCarousel);

        function startSlide() {
            slideInterval = setInterval(() => {
                currentIndex++;
                if (currentIndex >= items.length) {
                    currentIndex = 0;
                }
                updateCarousel();
            }, 1500); 
        }

        function stopSlide() {
            clearInterval(slideInterval);
        }

        // Start auto play
        startSlide();

        // Pause auto play on hover
        container.addEventListener('mouseenter', stopSlide);
        container.addEventListener('mouseleave', startSlide);
    });
</script>