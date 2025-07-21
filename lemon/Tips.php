<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\Tips.php

// --- SESSION AND LANGUAGE SETUP ---
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

// --- SECURITY (SESSION GUARD & TIMEOUT) ---
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

// --- DATABASE CONNECTION AND TRANSLATION LOADING ---
$servername = "localhost:3307";
$db_username = "root";
$db_password = "123456";
$dbname = "lemon";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Define which text groups we need for this page
$page_keys = ['nav', 'footer', 'common', 'tips']; 

// Include the translation loader
include __DIR__ . '/translations.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($texts['tips_page_title'] ?? 'Tips'); ?></title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="Tips.css">
</head>
<body>
    <header class="header">
        <h1 class="header-title"><?php echo htmlspecialchars($texts['tips_header_title'] ?? 'How To Make Lemonade'); ?></h1>
    </header>

    <div class="main-wrapper">
        <nav class="nav">
            <a href="index.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_home']); ?></a>
            <a href="Ingredient.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_ingredients']); ?></a>
            <a href="Instructions.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_instructions']); ?></a>
            <a href="Tips.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_tips']); ?></a>
            <a href="Variations.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_variations']); ?></a>
            <img src="../lemonpics/Lemonade-blog.jpg" alt="Lemonade" class="nav-img">
        </nav>

        <main class="container">
            <h2><?php echo htmlspecialchars($texts['tips_main_title']); ?></h2>
            <p><?php echo htmlspecialchars($texts['tips_main_intro']); ?></p>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip1_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip1_desc']); ?></p>
                </div>
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip2_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip2_desc']); ?></p>
                </div>
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip3_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip3_desc']); ?></p>
                </div>
                 <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip4_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip4_desc']); ?></p>
                </div>
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip5_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip5_desc']); ?></p>
                </div>
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip6_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip6_desc']); ?></p>
                </div>
                <div class="tip-card">
                    <h3><?php echo htmlspecialchars($texts['tip7_title']); ?></h3>
                    <p><?php echo htmlspecialchars($texts['tip7_desc']); ?></p>
                </div>
            </div>
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
        <p><?php echo htmlspecialchars($texts['footer_author']); ?> <a href="Thanks.php" class="footer-link"><?php echo htmlspecialchars($texts['footer_thanks']); ?></a></p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>