<?php
// 1. 引入資料庫連線設定
require_once 'config/db.php';

// 2. 🛡️ 安全檢查：將 ID 強制轉成整數，徹底阻擋 SQL 注入
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$news = null;

// 3. 撈取該筆特定 ID 的公告完整資料
if ($id > 0) {
    try {
        $query = "SELECT title, content, category, created_at FROM news WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        
        $news = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_msg = "資料庫讀取失敗";
    }
}

// 4. 引入前台網頁頂部
include 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/details.css">
<style>
    /* 公告內文專屬微調佈局 */
    .news-details-container { background: white; border-radius: 16px; padding: 50px 40px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid #edf2f7; }
    .news-header-meta { display: flex; gap: 15px; align-items: center; color: #64748b; font-size: 0.95rem; margin-bottom: 20px; }
    .news-full-content { font-size: 1.1rem; color: #334155; line-height: 1.9; text-align: justify; margin-top: 30px; }
    .news-full-content p { margin-bottom: 1.5rem; }
</style>

<main class="container py-5">
    
    <div class="back-nav" style="margin-bottom: 30px;">
        <a href="news.php" class="btn-back" style="color: #4f46e5; font-weight: 600; text-decoration: none;">← 返回最新公告列表</a>
    </div>

    <?php if ($news): ?>
        <?php
        // 安全安全性過濾
        $title = htmlspecialchars($news['title']);
        $category = htmlspecialchars($news['category'] ?? '一般');
        $date = date('Y-m-d H:i', strtotime($news['created_at']));
        
        // 💡 備註：因為後台公告內容有時候會需要夾帶 HTML 標籤(例如連結或粗體)，
        // 如果後台有用富文本編輯器，這裡就不適用 htmlspecialchars，改用 strip_tags 或直接輸出（需確保後台防禦安全）
        // 這裡暫時使用安全過濾，並支援換行
        $content = nl2br(htmlspecialchars($news['content']));
        ?>

        <article class="news-details-container">
            <div class="news-header-meta">
                <span class="news-tag" style="background-color: #e0e7ff; color: #4f46e5; padding: 4px 12px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">
                    <?php echo $category; ?>
                </span>
                <time class="news-detail-time">📅 發布時間：<?php echo $date; ?></time>
            </div>

            <h1 class="detail-name" style="font-size: 2.2rem; line-height: 1.4; color: #1e293b; margin-bottom: 20px;">
                <?php echo $title; ?>
            </h1>
            
            <hr class="divider" style="border: 0; height: 1px; background: #e2e8f0; margin: 20px 0;">

            <div class="news-full-content">
                <?php echo $content; ?>
            </div>
        </article>

    <?php else: ?>
        <div class="error-container" style="text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; border: 1px solid #edf2f7;">
            <h2 style="color: #ef4444; margin-bottom: 15px;">⚠️ 抱歉，找不到該則公告內容！</h2>
            <p style="color: #64748b; margin-bottom: 30px;">此公告可能已被管理員刪除，或者您輸入了錯誤的網址參數。</p>
            <a href="news.php" class="btn-home" style="background: #4f46e5; color: white; padding: 10px 24px; border-radius: 6px; font-weight: 600;">返回公告列表</a>
        </div>
    <?php endif; ?>

</main>

<?php
// 5. 引入前台網頁底部
include 'includes/footer.php';
?>