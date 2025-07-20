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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>How To Make Lemonade</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <div class="header">
        <header>
            <div class="header-title">HTML——How To Make Lemonade</div>
        </header>
    </div>

    <div class="main-wrapper">
        <nav class="nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="Ingredient.php" class="nav-link">Ingredients</a>
            <a href="Instructions.php" class="nav-link">Instructions</a>
            <a href="Tips.php" class="nav-link">Tips</a>
            <a href="Variations.php" class="nav-link">Variations</a>
            <img src="../lemonpics/Lemonade-blog.jpg" alt="Lemonade" class="nav-img">
        </nav>

        <main class="container">
            <h2>Welcome to the Ultimate Lemonade Guide!</h2>
            <p>This page is your one-stop resource for making delicious, refreshing homemade lemonade. Whether you're a beginner or a seasoned pro, you'll find everything you need right here. Use the navigation on the left to explore detailed ingredients, step-by-step instructions, pro tips, and creative variations!</p>

            <div class="content-block">
                <img src="../lemonpics/lemonade.png" alt="Lemons and Sugar">
                <div class="text-block">
                    <h3>The Basic Idea</h3>
                    <p>Making lemonade is incredibly simple. At its core, it's just three ingredients: fresh lemon juice, water, and a sweetener (usually sugar). The magic lies in getting the balance just right. We'll guide you through creating a "simple syrup" to ensure your sugar dissolves perfectly, giving you a smooth, consistently sweet drink every time.</p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/lemon_2.png" alt="Pitcher of Lemonade">
                <div class="text-block">
                    <h3>From Juice to Joy</h3>
                    <p>The process involves juicing fresh lemons, creating a simple sugar-water syrup, and then combining everything in a large pitcher with cold water. After a good stir and some time to chill in the refrigerator, you'll have a perfect pitcher of classic lemonade ready to be served over ice. It's the perfect drink for a hot summer day!</p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/lemon_1.png" alt="Glass of homemade lemonade">
                <div class="text-block">
                    <h3>Why Make Your Own?</h3>
                    <p>Store-bought lemonade can be full of artificial flavors and preservatives. When you make it at home, you control the ingredients. You can adjust the sweetness, use fresh, high-quality lemons, and know exactly what's in your glass. Plus, the taste of freshly made lemonade is simply unbeatable!</p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/Lemonade-blog.jpg" alt="Juicer and pitcher">
                <div class="text-block">
                    <h3>Basic Tools You'll Need</h3>
                    <p>You don't need any fancy equipment. A good juicer (manual or electric), a small saucepan for the syrup, a large pitcher for mixing, and a long spoon for stirring are all it takes to get started on your lemonade-making journey.</p>
                </div>
            </div>

            <p>Ready to get started? Click on "Ingredients" in the navigation bar to see what you'll need!</p>
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