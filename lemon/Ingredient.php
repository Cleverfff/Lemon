<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\index.php
// --- SESSION GUARD & TIMEOUT LOGIC ---
session_start();

// 1. 检查用户是否已登录
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
    exit;
}

// 2. 检查15分钟（900秒）不活动超时
$inactive_time = 900; 
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive_time) {
    // 如果超时，销毁会话并重定向
    session_unset();
    session_destroy();
    header("location: login.html?reason=session_expired");
    exit;
}

// 3. 如果未超时，更新最后活动时间
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredients - How To Make Lemonade</title>
    <!-- 链接到与 index.html 相同的样式表以保持一致性 -->
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <header class="header">
        <h1 class="header-title">HTML——How To Make Lemonade</h1>
    </header>

    <div class="main-wrapper">
        <nav class="nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="Ingredient.php" class="nav-link">Ingredients</a>
            <a href="Instructions.php" class="nav-link">Instructions</a>
            <a href="Tips.php" class="nav-link">Tips</a>
            <a href="Variations.php" class="nav-link">Variations</a>
            <img src="../lemonpics/Lemonade-blog.jpg" alt="Lemonade" class="nav-img">
        </nav>

        <!-- 页面主要内容区 -->
        <main class="container">
            <h2>What You'll Need</h2>
            <p>Gather these fresh and simple ingredients to create the perfect glass of lemonade.</p>
            
            <div class="ingredient-list">
                <div class="ingredient-item">
                    <img src="../lemonpics/lemon.png" alt="Fresh Lemons">
                    <h3>Fresh Lemons</h3>
                    <p>The star of the show! About 4-6 medium-sized lemons are needed for a standard pitcher.</p>
                </div>
                <div class="ingredient-item">
                    <img src="../lemonpics/water.jpeg" alt="Water">
                    <h3>Water</h3>
                    <p>Use cold, filtered water for the best taste. You'll need about 4 cups.</p>
                </div>
                <div class="ingredient-item">
                    <img src="../lemonpics/suger.jpeg" alt="Sugar" style="width: 50%;">
                    <h3>Sugar</h3>
                    <p>Granulated sugar works best. Start with 1 cup and adjust to your preferred sweetness.</p>
                </div>
                 <div class="ingredient-item">
                    <img src="../lemonpics/Ice_cubes.jpeg" alt="Ice Cubes" style="width: 50%;">
                    <h3>Ice Cubes</h3>
                    <p>Optional, but highly recommended for a refreshing, chilled drink.</p>
                </div>
                <!-- --- ADDED CONTENT FOR SCROLLING --- -->
                <div class="ingredient-item">
                    <img src="../lemonpics/Mint_Lemonade.jpeg" alt="Mint for Garnish">
                    <h3>Fresh Mint (Garnish)</h3>
                    <p>A few sprigs of fresh mint add a wonderful aroma and a touch of color.</p>
                </div>
                <div class="ingredient-item">
                    <img src="../lemonpics/Honey.jpeg" alt="Honey" style="width: 50%;">
                    <h3>Honey (Optional)</h3>
                    <p>For a natural sweetener, honey is a great alternative to sugar. Use to taste.</p>
                </div>
                <div class="ingredient-item">
                    <img src="../lemonpics/Lemonade_stand.jpeg" alt="Lemonade Stand">
                    <h3>Lemonade Stand (Optional)</h3>
                    <p>If you're making this for a party or gathering, a lemonade stand makes a great presentation!</p>
                </div>
            </div>
        </main>

        <aside class="func">
            <!-- --- USER STATUS MODULE START --- -->
            <div class="user-status-module">
                <h4>用户状态</h4>
                <p>用户: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p>登录于: <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></p>
                <a href="logout.php" class="logout-btn">登出</a>
            </div>
            <!-- --- USER STATUS MODULE END --- -->
        </aside>
    </div>

    <footer class="footer">
        <p>How To Make Lemonade Author: Pan Zitao. <a href="Thanks.php" class="footer-link">Thanks to...</a></p>
    </footer>
</body>

</html>
