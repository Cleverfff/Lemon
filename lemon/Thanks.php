<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\Thanks.php

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acknowledgements - How To Make Lemonade</title>
    <link rel="stylesheet" type="text/css" href="Thanks.css">
</head>
<body>
    <div class="thanks-container">
        <h1>Acknowledgements</h1>
        
        <section class="thanks-section">
            <h2>Image Sources</h2>
            <ul>
                <li>
                    <strong>Lemonade-blog.jpg:</strong> 
                    <a href="https://bellyfull.net/homemade-lemonade-recipe/" target="_blank" rel="noopener noreferrer">bellyfull.net</a>
                </li>
                <!-- Add other image sources here -->
            </ul>
        </section>

        <section class="thanks-section">
            <h2>Special Thanks</h2>
            <ul>
                <li>To FATFATHAO, my friend who helps me learn making websites.</li>
                <li>To my classmates who share their knowledge with me.</li>
                <li>...and to you for visiting!</li>
            </ul>
        </section>

        <a href="index.php" class="back-link">Back to Home</a>
    </div>
</body>
</html>