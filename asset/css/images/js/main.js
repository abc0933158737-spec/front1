/**
 * ==========================================================================
 * 🌐 全域核心 JavaScript (main.js)
 * ==========================================================================
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // 🔔 1. 手機版導覽選單切換 (Hamburger Menu)
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            // 切換 active 類別，搭配 CSS 控制顯示或隱藏
            navLinks.classList.toggle('active');
            menuToggle.classList.toggle('is-open');
        });
    }


    // 🔔 2. 網頁滾動效果 (Navbar Scroll Effect)
    const header = document.querySelector('header'); // 或者你的 navbar class
    
    window.addEventListener('scroll', function() {
        // 當網頁向下捲動超過 50px 時，幫 header 加上 'scrolled' 類別
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });


    // 🔔 3. 點擊導覽列以外的地方自動收合手機選單 (優化體驗)
    document.addEventListener('click', function(event) {
        if (navLinks && navLinks.classList.contains('active')) {
            // 如果點擊的目標不是選單本身，也不是打開選單的按鈕，就將選單收起來
            if (!navLinks.contains(event.target) && !menuToggle.contains(event.target)) {
                navLinks.classList.remove('active');
                menuToggle.classList.remove('is-open');
            }
        }
    });
    
    // 🔔 4. 手機版點擊下拉選單控制
const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector('.dropdown-toggle');
    
    if (toggle) {
        toggle.addEventListener('click', function(e) {
            // 只有在手機/平板版寬度下，才攔截點擊事件改用展開式
            if (window.innerWidth <= 768) {
                e.preventDefault(); // 阻擋 a 標籤預設跳轉 #
                
                // 切換當前下拉選單的 open 狀態
                dropdown.classList.toggle('open');
                
                // 同時關閉其他沒被點到的下拉選單（選配，體驗較佳）
                dropdowns.forEach(other => {
                    if (other !== dropdown) {
                        other.classList.remove('open');
                    }
                });
            }
        });
    }
});

});