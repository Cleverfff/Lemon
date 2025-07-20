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
    <title>Tips - How To Make Lemonade</title>
    <!-- 链接主样式表 -->
    <link rel="stylesheet" type="text/css" href="index.css">
    <!-- 链接此页面特定的样式表 -->
    <link rel="stylesheet" type="text/css" href="Tips.css">
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
            <h2>Pro Tips for the Best Lemonade</h2>
            <p>Elevate your lemonade game with these expert tips and tricks.</p>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <h3>Use a Simple Syrup</h3>
                    <p>Dissolving sugar in hot water first ensures it mixes perfectly and doesn't sink to the bottom of the pitcher.</p>
                </div>
                <div class="tip-card">
                    <h3>Roll Your Lemons</h3>
                    <p>Before cutting, firmly roll lemons on the counter. This breaks down the membranes and makes them much easier to juice.</p>
                </div>
                <div class="tip-card">
                    <h3>Adjust to Taste</h3>
                    <p>Everyone's preference is different. Start with the base recipe, then add more sugar for sweetness or more lemon for tartness.</p>
                </div>
                 <div class="tip-card">
                    <h3>Zest for Flavor</h3>
                    <p>For an extra burst of lemon aroma, add a bit of lemon zest to the simple syrup while it heats, then strain it out.</p>
                </div>
                <!-- --- ADDED CONTENT FOR SCROLLING --- -->
                <div class="tip-card">
                    <h3>Use Cold Water</h3>
                    <p>Always start with cold, preferably filtered, water. It makes the final product more refreshing from the start.</p>
                </div>
                <div class="tip-card">
                    <h3>Make Ice Cubes from Lemonade</h3>
                    <p>To prevent your drink from getting diluted, freeze some of the lemonade in an ice cube tray and use those instead of regular ice.</p>
                </div>
                <div class="tip-card">
                    <h3>Let it Mellow</h3>
                    <p>The flavors of lemonade meld and improve after chilling for an hour or two. Making it ahead of time is a great idea.</p>
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