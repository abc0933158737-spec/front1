<?php
// 1. 開啟 Session 紀錄機制
session_start();

// 2. 🔒 安全檢查：如果沒有登入後台的 Session 紀錄，直接強制跳轉回登入頁
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// 3. 引入資料庫連線 (注意：因為在 admin 資料夾內，路徑要往上一層 `../`)
require_once '../config/db.php';

// 4. 初始化數據變數
$total_teachers = 0;
$latest_teachers = [];

try {
    // 📊 數據統計：計算目前資料庫共有幾位老師
    $count_query = "SELECT COUNT(*) AS total FROM teachers";
    $count_stmt = $pdo->query($count_query);
    $count_result = $count_stmt->fetch(PDO::FETCH_ASSOC);
    $total_teachers = $count_result['total'];

    // 📋 撈出最新加入的 5 筆資料，準備在表格中呈現
    $list_query = "SELECT id, name, title, created_at FROM teachers ORDER BY id DESC LIMIT 5";
    $list_stmt = $pdo->query($list_query);
    $latest_teachers = $list_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_msg = "資料庫讀取失敗";
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理系統 - 儀表板</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

    <div class="admin-wrapper">
        
        <aside class="admin-sidebar">
            <div class="sidebar-brand">
                <h2>系統後台</h2>
            </div>
            <nav class="sidebar-menu">
                <a href="index.php" class="active">📊 儀表板首頁</a>
                <a href="manage_teachers.php">👥 師資成員管理</a>
                <hr class="sidebar-divider">
                <a href="logout.php" class="logout-btn">🚪 安全登出</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <div class="welcome-msg">
                    歡迎回來，最高管理員 <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></strong>
                </div>
                <div class="view-front">
                    <a href="../index.php" target="_blank">🌐 前往觀看前台網站</a>
                </div>
            </header>

            <div class="main-content">
                <h1 class="page-title">儀表板數據概覽</h1>

                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-info">
                            <h3>目前成員總數</h3>
                            <p class="stat-number"><?php echo $total_teachers; ?></p>
                        </div>
                    </div>
                    </div>

                <div class="dashboard-section">
                    <div class="section-header">
                        <h2>⏱️ 最新加入的成員 (最新 5 筆)</h2>
                        <a href="manage_teachers.php" class="btn-primary">管理所有成員</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>姓名</th>
                                    <th>職稱 / 標籤</th>
                                    <th>建立時間</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($latest_teachers)): ?>
                                    <?php foreach ($latest_teachers as $t): ?>
                                        <tr>
                                            <td>#<?php echo $t['id']; ?></td>
                                            <td><strong><?php echo htmlspecialchars($t['name']); ?></strong></td>
                                            <td><span class="admin-badge"><?php echo htmlspecialchars($t['title']); ?></span></td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($t['created_at'])); ?></td>
                                            <td>
                                                <a href="manage_teachers.php?action=edit&id=<?php echo $t['id']; ?>" class="btn-edit">編輯</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">目前資料庫沒有任何成員資料。</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>