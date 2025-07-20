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
    <title>Variations - How To Make Lemonade</title>
    <!-- 链接主样式表 -->
    <link rel="stylesheet" type="text/css" href="index.css">
    <!-- 链接此页面特定的样式表 -->
    <link rel="stylesheet" type="text/css" href="Variations.css">
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
            <h2>Creative Variations</h2>
            <p>Give your classic lemonade a twist with these fun and flavorful variations.</p>
            
            <div class="variations-container">
                <div class="variation-item">
                    <img src="../lemonpics/Strawberry_Lemonade.png" alt="Strawberry Lemonade">
                    <div class="variation-description">
                        <h3>Strawberry Lemonade</h3>
                        <p>Blend fresh or frozen strawberries and strain the puree into your classic lemonade for a sweet, pink treat.</p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="../lemonpics/Mint_Lemonade.jpeg" alt="Mint Lemonade">
                    <div class="variation-description">
                        <h3>Mint Lemonade</h3>
                        <p>Muddle fresh mint leaves at the bottom of your pitcher before adding the other ingredients for a cool, refreshing flavor.</p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="../lemonpics/Lavender_Lemonade.jpeg" alt="Lavender Lemonade">
                    <div class="variation-description">
                        <h3>Lavender Lemonade</h3>
                        <p>Infuse your simple syrup with dried lavender buds to create an elegant, floral, and calming version of the classic.</p>
                    </div>
                </div>
                <!-- --- ADDED CONTENT FOR SCROLLING --- -->
                <div class="variation-item">
                    <img src="../lemonpics/Raspberry_Lemonade.jpeg" alt="Raspberry Lemonade">
                    <div class="variation-description">
                        <h3>Raspberry Lemonade</h3>
                        <p>Similar to strawberry, muddle fresh raspberries and add them to the mix for a vibrant color and tart flavor.</p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="../lemonpics/Spicy_Ginger_Lemonade.jpeg" alt="Ginger Lemonade">
                    <div class="variation-description">
                        <h3>Spicy Ginger Lemonade</h3>
                        <p>Add a few slices of fresh ginger to your simple syrup as it heats. This gives the lemonade a warm, spicy kick.</p>
                    </div>
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
