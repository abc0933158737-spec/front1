<?php
// 1. 引入資料庫連線設定
require_once 'config/db.php';

// 2. 引入前台網頁頂部 (Navbar)
include 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/index.css">

<section class="carousel-container">
    <div class="carousel-slide active">
        <img src="assets/images/banner1.jpg" alt="系所大圖海報">
        <div class="carousel-caption">
            <h2>邁向資訊科技的未來</h2>
            <p>掌握核心技術，開啟無限可能的學術與職涯之路</p>
        </div>
    </div>
    </section>

<main class="index-main container py-5">
    
    <section class="home-news-section">
        <div class="section-header">
            <h2 class="section-title">📢 最新公告</h2>
            <a href="news.php" class="btn-more">查看更多公告 →</a>
        </div>
        
        <div class="news-list-box">
            <?php
            try {
                // 撈出最新 3 筆公告 (假設 news 表有 id, title, content, created_at, category)
                $news_query = "SELECT id, title, content, created_at, category FROM news ORDER BY id DESC LIMIT 3";
                $news_stmt = $pdo->query($news_query);
                
                if ($news_stmt->rowCount() > 0) {
                    while ($news = $news_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $news_id = htmlspecialchars($news['id']);
                        $news_title = htmlspecialchars($news['title']);
                        $news_date = date('Y-m-d', strtotime($news['created_at']));
                        $news_cate = htmlspecialchars($news['category'] ?? '一般');
                        
                        // 擷取部分內文當摘要
                        $news_summary = mb_strimwidth(strip_tags($news['content']), 0, 150, "...");
                        ?>
                        
                        <div class="news-item">
                            <div class="news-meta">
                                <span class="news-date"><?php echo $news_date; ?></span>
                                <span class="news-tag"><?php echo $news_cate; ?></span>
                            </div>
                            <div class="news-body">
                                <h3>
                                    <a href="news_details.php?id=<?php echo $news_id; ?>">
                                        <?php echo $news_title; ?>
                                    </a>
                                </h3>
                                <p><?php echo $news_summary; ?></p>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo '<p class="no-data-msg">目前暫無任何公告資訊。</p>';
                }
            } catch (PDOException $e) {
                echo '<p class="error-msg">無法載入最新公告（請確認資料庫 news 表是否已建立）。</p>';
            }
            ?>
        </div>
    </section>

    <section class="home-admission-section">
        <h2 class="section-title text-center">🎓 招生專區</h2>
        <p class="section-subtitle text-center">歡迎加入我們的大家庭，探索最適合你的學程</p>
        
        <div class="admission-grid">
            <div class="admission-card">
                <div class="card-icon">👨‍🎓</div>
                <h3>學士班</h3>
                <p>多元化的核心資訊課程、專題實作競賽，培養實戰技術人才。</p>
                <a href="admission.php?type=undergraduate" class="btn-card-link">簡章與資格說明</a>
            </div>
            
            <div class="admission-card">
                <div class="card-icon">🔬</div>
                <h3>碩士班 / 碩專班</h3>
                <p>前沿科技研究、產學合作機會，深耕人工智慧與巨量資料分析技術。</p>
                <a href="admission.php?type=graduate" class="btn-card-link">研究領域與報名</a>
            </div>
        </div>
    </section>

</main>

<?php
// 3. 引入前台網頁底部 (Footer)
include 'includes/footer.php';
?>