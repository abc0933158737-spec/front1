<?php
// 1. 引入資料庫連線設定
require_once 'config/db.php';

// 2. 安全機制：強制轉為整數，阻擋惡意 SQL 注入攻擊碼
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$teacher = null;

// 3. 如果有收到合法的 ID，就去資料庫撈特定成員細節
if ($id > 0) {
    try {
        $query = "SELECT name, title, bio, image_url, created_at FROM teachers WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        
        $teacher = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $error_msg = "資料庫讀取失敗";
    }
}

// 4. 引入前台網頁頂部 (包含導覽列)
include 'includes/header.php';
?>

<link rel="stylesheet" href="assets/css/details.css">

<main class="container py-5">
    
    <div class="back-nav">
        <a href="teachers.php" class="btn-back">← 返回系所成員列表</a>
    </div>

    <?php if ($teacher): ?>
        <?php
        // 安全性變數過濾
        $name = htmlspecialchars($teacher['name']);
        $title = htmlspecialchars($teacher['title']);
        $bio = htmlspecialchars($teacher['bio']);
        $image_url = htmlspecialchars($teacher['image_url']);
        
        if (empty($image_url)) {
            $image_url = 'default_avatar.png';
        }
        ?>

        <div class="details-wrapper">
            <div class="details-left">
                <div class="profile-image-container">
                    <img src="assets/images/<?php echo $image_url; ?>" alt="<?php echo $name; ?>">
                </div>
            </div>

            <div class="details-right">
                <span class="detail-badge">Faculty Member</span>
                <h1 class="detail-name"><?php echo $name; ?></h1>
                <p class="detail-title"><?php echo $title; ?></p>
                
                <hr class="divider">

                <h3 class="section-heading">🔬 研究領域與個人簡介</h3>
                <p class="detail-bio"><?php echo nl2br($bio); ?></p>
                
                <div class="detail-meta">
                    <small>資料更新時間：<?php echo date('Y-m-d', strtotime($teacher['created_at'])); ?></small>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="error-container">
            <h2>⚠️ 抱歉，找不到該成員的詳細資料！</h2>
            <p>請確認網址列的 ID 是否正確，或者該成員已被系統管理員移除。</p>
            <a href="teachers.php" class="btn-home">返回成員列表</a>
        </div>
    <?php endif; ?>

</main>

<?php
// 5. 引入前台網頁底部
include 'includes/footer.php';
?>