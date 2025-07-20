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
    <title>Instructions - How To Make Lemonade</title>
    <!-- 链接主样式表 -->
    <link rel="stylesheet" type="text/css" href="index.css">
    <!-- 链接此页面特定的样式表 -->
    <link rel="stylesheet" type="text/css" href="Instructions.css">
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
            <h2>Step-by-Step Guide</h2>
            <p>Follow these simple steps to craft your refreshing homemade lemonade.</p>
            
            <div class="instruction-steps">
                <div class="step-item">
                    <h3>Squeeze the Lemons</h3>
                    <p>Cut the lemons in half and squeeze the juice into a large pitcher. Remove any seeds.</p>
                </div>
                <div class="step-item">
                    <h3>Make Simple Syrup</h3>
                    <p>In a small saucepan, combine sugar and 1 cup of water. Heat over medium heat, stirring until the sugar has completely dissolved. Let it cool.</p>
                </div>
                <div class="step-item">
                    <h3>Combine Ingredients</h3>
                    <p>Pour the cooled simple syrup and the remaining 3 cups of cold water into the pitcher with the lemon juice. Stir well to combine.</p>
                </div>
                 <div class="step-item">
                    <h3>Chill and Serve</h3>
                    <p>Refrigerate the lemonade for at least 30 minutes. Serve over ice with a lemon slice for garnish.</p>
                </div>
                <!-- --- ADDED CONTENT FOR SCROLLING --- -->
                <div class="step-item">
                    <h3>Taste and Adjust</h3>
                    <p>Before serving, give it a final taste. If it's too tart, add a bit more sugar syrup. If too sweet, a splash more lemon juice.</p>
                </div>
                <div class="step-item">
                    <h3>Garnish Creatively</h3>
                    <p>Add fresh mint sprigs, strawberry slices, or even a few blueberries to the pitcher for extra color and flavor.</p>
                </div>
                <div class="step-item">
                    <h3>Storage</h3>
                    <p>Store any leftover lemonade in a sealed container in the refrigerator for up to 3 days.</p>
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