<?php
// 自動偵測當前檔案名稱，用來做導覽列的 active 效果
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>資訊工程系所展示網站</title>
    <link rel="stylesheet" href="assets/css/style.css">
    </head>
<body>

    <header class="main-navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php">
                    <img src="assets/images/logo.png" alt="系所 Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span style="display:none;" class="logo-fallback">🌐 系所資訊網</span>
                </a>
            </div>

            <nav class="nav-menu">
                <ul>
                    <li>
                        <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                            🏠 首頁
                        </a>
                    </li>
                    
                    <li>
                        <a href="news.php" class="<?php echo ($current_page == 'news.php' || $current_page == 'news_details.php') ? 'active' : ''; ?>">
                            📢 最新公告
                        </a>
                    </li>

                    <li>
                        <a href="admission.php" class="<?php echo ($current_page == 'admission.php') ? 'active' : ''; ?>">
                            🎓 招生專區
                        </a>
                    </li>

                    <li>
                        <a href="teachers.php" class="<?php echo ($current_page == 'teachers.php' || $current_page == 'teacher_details.php') ? 'active' : ''; ?>">
                            👥 系所成員
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="nav-action">
                <a href="admin/login.php" class="btn-nav-admin" target="_blank">進入後台</a>
            </div>
        </div>
    </header>

    <div class="navbar-spacer"></div>