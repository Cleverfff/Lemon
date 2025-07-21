<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\index.php

// --- 1. SESSION AND LANGUAGE SETUP ---
session_start();

$available_langs = [
    'en' => 'English',
    'zh' => '中文',
    'de' => 'Deutsch'
];

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $available_langs)) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: " . basename($_SERVER['PHP_SELF']));
    exit();
}

$current_lang_code = $_SESSION['lang'];
$current_lang_name = $available_langs[$current_lang_code];

// --- 2. SECURITY (SESSION GUARD & TIMEOUT) ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
    exit;
}

$inactive_time = 900;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive_time) {
    session_unset();
    session_destroy();
    header("location: login.html?reason=session_expired");
    exit;
}
$_SESSION['last_activity'] = time();

// --- 3. DATABASE CONNECTION AND TRANSLATION LOADING ---
// Database connection details
$servername = "localhost:3307";
$db_username = "root";
$db_password = "123456";
$dbname = "lemon";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Ensure characters are handled correctly
$conn->set_charset("utf8mb4");

// Define which text groups we need for this page
// FIX: Add 'common' to the array to load texts for the function bar
$page_keys = ['nav', 'footer', 'home', 'common']; 

// Include the translation loader to fetch the texts
// Corrected filename to match your file system
include __DIR__ . '/translations.php';

// The $texts array is now available for use below
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- Using the new, specific key -->
    <title><?php echo htmlspecialchars($texts['home_header_title'] ?? 'How To Make Lemonade'); ?></title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <div class="header">
        <header>
            <!-- Using the new, specific key -->
            <div class="header-title"><?php echo htmlspecialchars($texts['home_header_title'] ?? 'Lemonade Guide'); ?></div>
        </header>
    </div>

    <div class="main-wrapper">
        <nav class="nav">
            <!-- Replacing all navigation links with translated text -->
            <a href="index.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_home']); ?></a>
            <a href="Ingredient.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_ingredients']); ?></a>
            <a href="Instructions.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_instructions']); ?></a>
            <a href="Tips.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_tips']); ?></a>
            <a href="Variations.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_variations']); ?></a>
            <img src="../lemonpics/Lemonade-blog.jpg" alt="Lemonade" class="nav-img">
        </nav>

        <main class="container">
            <!-- Using the new, specific keys -->
            <h2><?php echo htmlspecialchars($texts['home_main_title']); ?></h2>
            <p><?php echo htmlspecialchars($texts['home_main_intro']); ?></p>

            <!-- All content blocks are now translated -->
            <div class="content-block">
                <img src="../lemonpics/lemonade.png" alt="Lemons and Sugar">
                <div class="text-block">
                    <h3><?php echo htmlspecialchars($texts['block1_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['block1_text']); ?></p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/lemon_2.png" alt="Pitcher of Lemonade">
                <div class="text-block">
                    <h3><?php echo htmlspecialchars($texts['block2_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['block2_text']); ?></p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/lemon_1.png" alt="Glass of homemade lemonade">
                <div class="text-block">
                    <h3><?php echo htmlspecialchars($texts['block3_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['block3_text']); ?></p>
                </div>
            </div>

            <div class="content-block">
                <img src="../lemonpics/Lemonade-blog.jpg" alt="Juicer and pitcher">
                <div class="text-block">
                    <h3><?php echo htmlspecialchars($texts['block4_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['block4_text']); ?></p>
                </div>
            </div>

            <p><?php echo htmlspecialchars($texts['main_outro']); ?></p>
        </main>

        <aside class="func">
            <div class="user-status-module">
                <h4><?php echo htmlspecialchars($texts['status_title']); ?></h4>
                <p><?php echo htmlspecialchars($texts['status_user']); ?> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><?php echo htmlspecialchars($texts['status_logintime']); ?> <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></p>
                <a href="logout.php" class="logout-btn"><?php echo htmlspecialchars($texts['status_logout_btn']); ?></a>
            </div>

            <div class="language-switcher-module">
                <h4><?php echo htmlspecialchars($texts['lang_title']); ?></h4>
                <p><?php echo htmlspecialchars($texts['lang_current']); ?> <?php echo $current_lang_name; ?></p>
                <div class="language-buttons">
                    <?php
                    foreach ($available_langs as $lang_code => $lang_name) {
                        if ($lang_code !== $current_lang_code) {
                            echo '<a href="?lang=' . $lang_code . '" class="lang-btn">' . $lang_name . '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </aside>
    </div>

    <footer class="footer">
        <!-- Using translated text for the footer -->
        <p><?php echo htmlspecialchars($texts['footer_author']); ?> <a href="Thanks.php" class="footer-link"><?php echo htmlspecialchars($texts['footer_thanks']); ?></a></p>
    </footer>
</body>
</html>
<?php
// Close the database connection at the end of the script
$conn->close();
?>