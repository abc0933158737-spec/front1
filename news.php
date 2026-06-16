<?php
// 1. 引入資料庫連線設定
require_once 'config/db.php';

// 2. 引入前台網頁頂部 (包含導覽列)
include 'includes/header.php';

// 3. 取得目前篩選的分類 (預設為 'all' 顯示全部)
$category = isset($_GET['cate']) ? trim($_GET['cate']) : 'all';
?>

<link rel="stylesheet" href="assets/css/index.css">
<style>
    /* 公告列表頁專屬微調樣式 */
    .cate-filter-bar { display: flex; gap: 12px; margin-bottom: 30px; flex-wrap: wrap; }
    .btn-cate { background: #e2e8f0; color: #475569; padding: 8px 18px; border-radius: 20px; font-weight: 600; font-size: 0.95rem; transition: 0.2s; }
    .btn-cate:hover, .btn-cate.active { background: #4f46e5; color: white; }
    .page-header { margin-bottom: 40px; }
    .page-title { font-size: 2rem; color: #1e293b; font-weight: bold; margin-bottom: 10px; }
    .page-subtitle { color: #64748b; font-size: 1.1rem; }
</style>

<main class="container py-5">
    <div class="page-header">
        <h1 class="page-title">📢 最新公告列表</h1>
        <p class="page-subtitle">即時掌握系所最新動態、學術演講、榮譽榜與招生資訊</p>
    </div>

    <div class="cate-filter-bar">
        <a href="news.php?cate=all" class="btn-cate <?php echo ($category === 'all') ? 'active' : ''; ?>">全部公告</a>
        <a href="news.php?cate=招生" class="btn-cate <?php echo ($category === '招生') ? 'active' : ''; ?>">🎓 招生資訊</a>
        <a href="news.php?cate=學術" class="btn-cate <?php echo ($category === '學術') ? 'active' : ''; ?>">🔬 學術演講</a>
        <a href="news.php?cate=榮譽" class="btn-cate <?php echo ($category === '榮譽') ? 'active' : ''; ?>">🏆 榮譽榜</a>
        <a href="news.php?cate=一般" class="btn-cate <?php echo ($category === '一般') ? 'active' : ''; ?>">💼 一般公告</a>
    </div>

    <div class="news-list-box">
        <?php
        try {
            // 4. 根據分類動態構建 SQL 語法
            if ($category !== 'all') {
                $query = "SELECT id, title, content, category, created_at FROM news WHERE category = :category ORDER BY id DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['category' => $category]);
            } else {
                $query = "SELECT id, title, content, category, created_at FROM news ORDER BY id DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            }

            // 5. 渲染公告資料
            if ($stmt->rowCount() > 0) {
                while ($news = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $news_id = htmlspecialchars($news['id']);
                    $news_title = htmlspecialchars($news['title']);
                    $news_date = date('Y-m-d', strtotime($news['created_at']));
                    $news_cate = htmlspecialchars($news['category'] ?? '一般');
                    
                    // 擷取前 150 字當卡片內文摘要
                    $news_summary = mb_strimwidth(strip_tags($news['content']), 0, 200, "...");
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
                echo '<p class="no-data-msg">🔍 目前該分類下沒有任何公告資訊。</p>';
            }
        } catch (PDOException $e) {
            echo '<p class="error-msg">❌ 系統忙碌中，無法載入公告列表。</p>';
        }
        ?>
    </div>
</main>

<?php
// 6. 引入前台網頁底部
include 'includes/footer.php';
?>