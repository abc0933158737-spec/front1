/**
 * ==========================================================================
 * 🎡 首頁 Banner 輪播效果 JavaScript (carousel.js)
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 抓取網頁上的輪播元件
    const items = document.querySelectorAll('.carousel-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const carouselSection = document.querySelector('.hero-carousel');
    
    // 防呆機制：如果不是首頁（找不到輪播元件），就直接收工，不跑後續程式碼
    if (items.length === 0) return;

    let currentIndex = 0;
    let timer = null;
    const intervalTime = 5000; // 自動輪播間隔時間：5000毫秒 (5秒)

    // 🔄 功能：切換到指定索引的圖片
    function showSlide(index) {
        // 移除目前顯示圖片的 active 類別
        items[currentIndex].classList.remove('active');
        
        // 更新索引值
        currentIndex = index;
        
        // 如果索引超出右邊界，回到第一張
        if (currentIndex >= items.length) {
            currentIndex = 0;
        }
        // 如果索引低於左邊界，回到最後一張
        if (currentIndex < 0) {
            currentIndex = items.length - 1;
        }
        
        // 為新圖片加上 active 類別（觸發 CSS opacity 漸變特效）
        items[currentIndex].classList.add('active');
    }

    // ➡️ 下一張按鈕點擊事件
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            showSlide(currentIndex + 1);
        });
    }

    // ⬅️ 上一張按鈕點擊事件
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            showSlide(currentIndex - 1);
        });
    }

    // ⏱️ 開啟自動輪播計時器
    function startAutoplay() {
        timer = setInterval(function() {
            showSlide(currentIndex + 1);
        }, intervalTime);
    }

    // 🛑 停止自動輪播計時器
    function stopAutoplay() {
        clearInterval(timer);
    }

    // 初始化：啟動自動輪播
    startAutoplay();

    // 🧘‍♂️ 貼心互動優化：當滑鼠移入 Banner 時暫停輪播，移出時繼續輪播
    if (carouselSection) {
        carouselSection.addEventListener('mouseenter', stopAutoplay);
        carouselSection.addEventListener('mouseleave', startAutoplay);
    }
});