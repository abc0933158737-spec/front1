<?php
// 1. 引入資料庫連線設定
require_once 'config/db.php';

// 2. 引入前台網頁頂部 (包含導覽列)
include 'includes/header.php';

// 3. 處理前端的搜尋關鍵字
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<link rel="stylesheet" href="assets/css/teachers.css">

<main class="container py-5">
    <div class="page-header">
        <h1 class="page-title">👥 系所成員團隊</h1>
        <p class="page-subtitle">探索來自各領域的專業教授、講師與核心成員</p>
    </div>

    <div class="toolbar">
        <form action="teachers.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="輸入關鍵字搜尋成員姓名或職稱..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn-search">🔍 搜尋</button>
            <?php if (!empty($search)): ?>
                <a href="teachers.php" class="btn-clear">清除</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="teachers-grid">
        <?php
        try {
            // 4. 根據是否有搜尋關鍵字，動態構建 SQL 語法 (防 SQL 注入)
            if (!empty($search)) {
                $query = "SELECT id, name, title, bio, image_url FROM teachers 
                          WHERE name LIKE :search OR title LIKE :search 
                          ORDER BY id ASC";
                $stmt = $pdo->prepare($query);
                $stmt->execute(['search' => '%' . $search . '%']);
            } else {
                $query = "SELECT id, name, title, bio, image_url FROM teachers ORDER BY id ASC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
            }

            // 5. 檢查是否有撈到任何資料
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = htmlspecialchars($row['id']);
                    $name = htmlspecialchars($row['name']);
                    $title = htmlspecialchars($row['title']);
                    $bio = htmlspecialchars($row['bio']);
                    $image_url = htmlspecialchars($row['image_url']);

                    // 預設大頭貼處理
                    if (empty($image_url)) {
                        $image_url = 'default_avatar.png';
                    }
                    ?>
                    
                    <div class="teacher-card">
                        <div class="avatar-box">
                            <img src="assets/images/<?php echo $image_url; ?>" alt="<?php echo $name; ?>">
                        </div>
                        <div class="teacher-info">
                            <h2><?php echo $name; ?></h2>
                            <span class="teacher-title"><?php echo $title; ?></span>
                            <p class="teacher-bio"><?php echo mb_strimwidth(strip_tags($bio), 0, 120, "..."); ?></p>
                        </div>
                        <div class="teacher-action">
                            <a href="teacher_details.php?id=<?php echo $id; ?>" class="btn-profile">查看完整網頁</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo '<div class="no-results">🔍 找不到符合條件的系所成員。</div>';
            }
        } catch (PDOException $e) {
            echo '<div class="error-msg">❌ 系統忙碌中，暫時無法取得成員列表。</div>';
        }
        ?>
    </div>
</main>

<?php
// 6. 引入前台網頁底部
include 'includes/footer.php';
?>