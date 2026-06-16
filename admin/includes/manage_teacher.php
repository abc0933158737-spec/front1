<?php
session_start();
// 🔒 安全檢查
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/db.php';

// 取得當前要執行的動作 (預設為列表 'list')
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$msg = ''; $error = '';

// ==========================================
// 🔥 核心邏輯處理 (POST 提交與 DELETE 刪除)
// ==========================================

// 1. 執行刪除動作
if ($action === 'delete' && $id > 0) {
    try {
        $stmt = $pdo->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        header('Location: manage_teachers.php?msg=deleted');
        exit;
    } catch (PDOException $e) { $error = "刪除失敗！"; }
}

// 2. 處理「新增」與「修改」表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $title = trim($_POST['title']);
    $bio = trim($_POST['bio']);
    $image_url = trim($_POST['image_url']); // 這裡暫先用文字輸入路徑，以便實作

    if (!empty($name) && !empty($title)) {
        try {
            if ($action === 'add') {
                // 執行新增 SQL
                $stmt = $pdo->prepare("INSERT INTO teachers (name, title, bio, image_url) VALUES (:name, :title, :bio, :image_url)");
                $stmt->execute(['name' => $name, 'title' => $title, 'bio' => $bio, 'image_url' => $image_url]);
                header('Location: manage_teachers.php?msg=added');
                exit;
            } elseif ($action === 'edit' && $id > 0) {
                // 執行更新 SQL
                $stmt = $pdo->prepare("UPDATE teachers SET name = :name, title = :title, bio = :bio, image_url = :image_url WHERE id = :id");
                $stmt->execute(['name' => $name, 'title' => $title, 'bio' => $bio, 'image_url' => $image_url, 'id' => $id]);
                header('Location: manage_teachers.php?msg=updated');
                exit;
            }
        } catch (PDOException $e) { $error = "資料庫寫入錯誤！"; }
    } else { $error = "姓名與職稱為必填欄位！"; }
}

// 處理網址跳轉提示
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added') $msg = "🎉 成功新增成員！";
    if ($_GET['msg'] === 'updated') $msg = "✏️ 資料更新成功！";
    if ($_GET['msg'] === 'deleted') $msg = "🗑️ 成員已成功刪除！";
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>後台管理 - 師資成員管理</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        /* 頁面專屬微調 */
        .alert-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; }
        .form-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 700px; }
        .form-ctrl { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; margin-bottom: 15px; font-size: 1rem; }
        .btn-group { display: flex; gap: 10px; }
        .btn-cancel { background: #95a5a6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; }
        .btn-danger { color: #e74c3c; text-decoration: none; font-weight: 600; margin-left: 10px; }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="sidebar-brand"><h2>系統後台</h2></div>
            <nav class="sidebar-menu">
                <a href="index.php">📊 儀表板首頁</a>
                <a href="manage_teachers.php" class="active">👥 師資成員管理</a>
                <hr class="sidebar-divider">
                <a href="logout.php" class="logout-btn">🚪 安全登出</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="main-header">
                <div class="welcome-msg">管理員專區 / <strong>師資管理</strong></div>
                <div class="view-front"><a href="../index.php" target="_blank">🌐 前台網站</a></div>
            </header>

            <div class="main-content">
                
                <?php if (!empty($msg)): ?><div class="alert-success"><?php echo $msg; ?></div><?php endif; ?>
                <?php if (!empty($error)): ?><div class="alert-danger"><?php echo $error; ?></div><?php endif; ?>

                <?php if ($action === 'add' || $action === 'edit'): ?>
                    <?php
                    // 如果是編輯，先撈出該筆舊資料填入表單
                    $t_name = ''; $t_title = ''; $t_bio = ''; $t_img = '';
                    if ($action === 'edit' && $id > 0) {
                        $stmt = $pdo->prepare("SELECT * FROM teachers WHERE id = :id");
                        $stmt->execute(['id' => $id]);
                        $t = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($t) {
                            $t_name = $t['name']; $t_title = $t['title']; $t_bio = $t['bio']; $t_img = $t['image_url'];
                        }
                    }
                    ?>
                    
                    <h1 class="page-title"><?php echo $action === 'add' ? '➕ 新增成員' : '✏️ 編輯成員資料'; ?></h1>
                    
                    <div class="form-box">
                        <form action="manage_teachers.php?action=<?php echo $action; ?>&id=<?php echo $id; ?>" method="POST">
                            <label>成員姓名 *</label>
                            <input type="text" name="name" class="form-ctrl" value="<?php echo htmlspecialchars($t_name); ?>" required>
                            
                            <label>職稱 / 標籤 *</label>
                            <input type="text" name="title" class="form-ctrl" value="<?php echo htmlspecialchars($t_title); ?>" placeholder="例如：網頁開發講師" required>
                            
                            <label>圖片檔名 (assets/images/ 目錄下)</label>
                            <input type="text" name="image_url" class="form-ctrl" value="<?php echo htmlspecialchars($t_img); ?>" placeholder="例如：teacher1.png (留空則使用預設大頭貼)">
                            
                            <label>個人簡介</label>
                            <textarea name="bio" class="form-ctrl" rows="6" placeholder="請輸入成員的詳細介紹..."><?php echo htmlspecialchars($t_bio); ?></textarea>
                            
                            <div class="btn-group">
                                <button type="submit" class="btn-primary" style="border:none; cursor:pointer;">儲存送出</button>
                                <a href="manage_teachers.php" class="btn-cancel">取消返回</a>
                            </div>
                        </form>
                    </div>

                <?php else: ?>
                    <div class="section-header">
                        <h1 class="page-title" style="margin:0;">👥 所有師資成員管理</h1>
                        <a href="manage_teachers.php?action=add" class="btn-primary">➕ 新增成員資料</a>
                    </div>

                    <div class="dashboard-section" style="margin-top:20px;">
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>姓名</th>
                                        <th>職稱 / 標籤</th>
                                        <th>建立時間</th>
                                        <th>功能操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("SELECT id, name, title, created_at FROM teachers ORDER BY id ASC");
                                    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    
                                    if (!empty($teachers)):
                                        foreach ($teachers as $t):
                                    ?>
                                        <tr>
                                            <td>#<?php echo $t['id']; ?></td>
                                            <td><strong><?php echo htmlspecialchars($t['name']); ?></strong></td>
                                            <td><span class="admin-badge"><?php echo htmlspecialchars($t['title']); ?></span></td>
                                            <td><?php echo date('Y-m-d', strtotime($t['created_at'])); ?></td>
                                            <td>
                                                <a href="manage_teachers.php?action=edit&id=<?php echo $t['id']; ?>" class="btn-edit">編輯修改</a>
                                                <a href="manage_teachers.php?action=delete&id=<?php echo $t['id']; ?>" class="btn-danger" onclick="return confirm('確定要刪除這名成員嗎？此動作無法復原！')">刪除</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        endforeach;
                                    else: 
                                    ?>
                                        <tr><td colspan="5" class="text-center">目前沒有任何成員資料，請點擊右上方新增。</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

</body>
</html>