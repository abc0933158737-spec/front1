<?php
// 如果未來招生資訊需要從資料庫動態抓取，可以在這裡引入 db.php
// require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>招生專區 - 系所同盟</title>
    
    <!-- 全域核心樣式 -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- 🎓 招生專區專用樣式 -->
    <link rel="stylesheet" href="assets/css/admission.css">
</head>
<body>

    <!-- 引入前台共用導覽列 -->
    <?php include 'includes/header.php'; ?>

    <!-- 頁面橫幅 (Hero Banner) -->
    <div class="admission-hero">
        <div class="hero-text">
            <h2>🎓 招生專區</h2>
            <p>加入我們，開啟你的專業與學術未來</p>
        </div>
    </div>

    <main class="container admission-container">
        
        <!-- 快速導覽選單 (內部錨點跳轉) -->
        <nav class="admission-nav">
            <ul>
                <li><a href="#undergrad">學士班招生</a></li>
                <li><a href="#graduate">碩士班 / 職專班招生</a></li>
                <li><a href="#downloads">重要表單下載</a></li>
            </ul>
        </nav>

        <!-- 區塊一：學士班招生 -->
        <section id="undergrad" class="admission-section">
            <div class="section-title">
                <h3>👨‍🎓 學士班招生資訊</h3>
            </div>
            
            <div class="admission-card">
                <h4>招生管道與名額</h4>
                <p>本系學士班旨在培育具備基礎理論與實務創新能力之人才。主要招生管道如下：</p>
                
                <table class="admission-table">
                    <thead>
                        <tr>
                            <th>招生管道</th>
                            <th>預計名額</th>
                            <th>重要時程 (參考)</th>
                            <th>簡章下載</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>特殊選才</td>
                            <td>3 名</td>
                            <td>每年 10 月 - 11 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                        <tr>
                            <td>申請入學</td>
                            <td>35 名</td>
                            <td>每年 3 月 - 5 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                        <tr>
                            <td>分發入學</td>
                            <td>15 名</td>
                            <td>每年 7 月 - 8 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="admission-card info-box">
                <h4>💡 備審資料準備指引</h4>
                <ul>
                    <li><strong>學習歷程檔案：</strong> 請著重於專題實作、競賽參與及核心課程的學習成果。</li>
                    <li><strong>多元表現：</strong> 語檢檢定、志工服務或自主學習計畫皆可列入加分參考。</li>
                </ul>
            </div>
        </section>

        <!-- 區塊二：碩士班 / 職專班招生 -->
        <section id="graduate" class="admission-section">
            <div class="section-title">
                <h3>🧑‍💻 碩士班 / 碩士在職專班招生資訊</h3>
            </div>
            
            <div class="admission-card">
                <h4>招生管道與名額</h4>
                <p>深化學術研究與產業實務結合，本系提供頂尖的研究環境與跨領域合作機會。</p>
                
                <table class="admission-table">
                    <thead>
                        <tr>
                            <th>班別 / 管道</th>
                            <th>招生方式</th>
                            <th>報名時間 (參考)</th>
                            <th>簡章下載</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>碩士班 (甄試入學)</td>
                            <td>書面審查 + 面試</td>
                            <td>每年 10 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                        <tr>
                            <td>碩士班 (考試入學)</td>
                            <td>筆試 / 書審</td>
                            <td>每年 12 月 - 隔年 1 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                        <tr>
                            <td>碩士在職專班</td>
                            <td>書面審查 + 面試</td>
                            <td>每年 12 月 - 隔年 1 月</td>
                            <td><a href="#" class="btn-download-sm">下載簡章</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 區塊三：重要表單下載 -->
        <section id="downloads" class="admission-section">
            <div class="section-title">
                <h3>📁 重要表單與相關連結</h3>
            </div>
            <div class="admission-card">
                <ul class="download-list">
                    <li>
                        <span class="file-type pdf">PDF</span>
                        <a href="#">學士班申請入學個人資料表 (自傳格式)</a>
                    </li>
                    <li>
                        <span class="file-type doc">WORD</span>
                        <a href="#">碩士班/職專班 教授推薦信推薦書樣張</a>
                    </li>
                    <li>
                        <span class="file-type link">LINK</span>
                        <a href="https://example.edu.tw" target="_blank">學校校級招生全球資訊網 🔗</a>
                    </li>
                </ul>
            </div>
        </section>

    </main>

    <!-- 引入前台共用頁尾 -->
    <?php include 'includes/footer.php'; ?>

    <!-- 引入全域 JS -->
    <script src="assets/js/main.js"></script>
</body>
</html>