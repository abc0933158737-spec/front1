<?php
session_start();
require_once '../config/db.php';

// 如果已經是登入狀態，直接導向儀表板
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        try {
            // 💡 假設你在資料庫建立了一個管理員表 `admin_users`
            // 如果暫時沒有建表，可以先解開下方「靜態帳密測試區」來寫死測試
            
            $query = "SELECT * FROM admin_users WHERE username = :username LIMIT 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                // 驗證成功，寫入 Session
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: index.php');
                exit;
            } else {
                $error = '帳號或密碼錯誤！';
            }
            
            
            /* 🔓 靜態帳密測試區 (如果資料庫還沒建管理員表，先用這個測試)
            if ($username === 'admin' && $password === '123456') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = 'admin';
                header('Location: index.php');
                exit;
            } else {
                $error = '帳號或密碼錯誤！';
            }
            */

        } catch (PDOException $e) {
            $error = '系統錯誤，請稍後再試';
        }
    } else {
        $error = '請填寫所有欄位！';
    }
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理系統 - 登入</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        /* 專屬登入頁的置中樣式 */
        .login-body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: #2c3e50; }
        .login-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 100%; max-width: 400px; }
        .login-card h2 { text-align: center; margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #666; font-weight: 600; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; }
        .btn-login { width: 100%; background: #1abc9c; color: white; border: none; padding: 12px; border-radius: 6px; font-size: 1rem; font-weight: bold; cursor: pointer; transition: 0.2s; }
        .btn-login:hover { background: #16a085; }
        .error-box { background: #fde8e8; color: #e53e3e; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; }
    </style>
</head>
<body class="login-body">

    <div class="login-card">
        <h2>管理員登入</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error-box"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>帳號 (Username)</label>
                <input type="text" name="username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>密碼 (Password)</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">安全登入</button>
        </form>
    </div>

</body>
</html>