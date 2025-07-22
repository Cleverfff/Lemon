<?php
/**
 * File: Variations.php
 * Author: Pan Zitao
 * Date: 2025-07-21
 * Description: Displays creative variations of the lemonade recipe.
 */

// --- 1. Initialization & Language Setup ---
session_start();

$available_langs = [
    'en' => 'English',
    'zh' => '中文',
    'de' => 'Deutsch'
];

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

$current_lang_code = $_SESSION['lang'];
$current_lang_name = $available_langs[$current_lang_code];

// --- 2. Security: Session & Activity Check ---
// Redirect to login if user is not authenticated.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
    exit;
}

// Log out user after 15 minutes of inactivity.
$inactive_time = 900;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $inactive_time) {
    session_unset();
    session_destroy();
    header("location: login.html?reason=session_expired");
    exit;
}
$_SESSION['last_activity'] = time();

// --- 3. Data Fetching ---
// Establish database connection.
$servername = "localhost:3307";
$db_username = "root";
$db_password = "123456";
$dbname = "lemon";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Load all necessary text translations for this page.
$page_keys = ['nav', 'footer', 'common', 'variations']; 

// Include the translation loader
include __DIR__ . '/translations.php';

// The $texts array is now populated and ready for use.
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Page title is dynamically set from the database. -->
    <title><?php echo htmlspecialchars($texts['variations_page_title'] ?? 'Variations'); ?></title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="Variations.css">
</head>
<body>
    <header class="header">
        <h1 class="header-title"><?php echo htmlspecialchars($texts['variations_header_title'] ?? 'How To Make Lemonade'); ?></h1>
    </header>

    <div class="main-wrapper">
        <nav class="nav">
            <!-- Navigation links are dynamically populated with translated text. -->
            <a href="index.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_home']); ?></a>
            <a href="Ingredient.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_ingredients']); ?></a>
            <a href="Instructions.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_instructions']); ?></a>
            <a href="Tips.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_tips']); ?></a>
            <a href="Variations.php" class="nav-link"><?php echo htmlspecialchars($texts['nav_variations']); ?></a>
            <img src="lemonpics/Pitcher of Lemonade.jpg" alt="Lemonade" class="nav-img">
        </nav>

        <main class="container">
            <!-- All main content is fetched from the database. -->
            <h2><?php echo htmlspecialchars($texts['variations_main_title']); ?></h2>
            <p><?php echo htmlspecialchars($texts['variations_main_intro']); ?></p>
            
            <div class="variations-container">
                <div class="variation-item">
                    <img src="lemonpics/Strawberry Lemonade.jpg" alt="Strawberry Lemonade" style="width: 80%; height: auto;">
                    <div class="variation-description">
                        <h3><?php echo htmlspecialchars($texts['var1_title']); ?></h3>
                        <p><?php echo htmlspecialchars($texts['var1_desc']); ?></p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="lemonpics/Mint Lemonade.jpg" alt="Mint Lemonade" style="width: 80%; height: auto;">
                    <div class="variation-description">
                        <h3><?php echo htmlspecialchars($texts['var2_title']); ?></h3>
                        <p><?php echo htmlspecialchars($texts['var2_desc']); ?></p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="lemonpics/Lavender Lemonade.jpg" alt="Lavender Lemonade" style="width: 80%; height: auto;">
                    <div class="variation-description">
                        <h3><?php echo htmlspecialchars($texts['var3_title']); ?></h3>
                        <p><?php echo htmlspecialchars($texts['var3_desc']); ?></p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="lemonpics/Raspberry Lemonade.jpg" alt="Raspberry Lemonade" style="width: 80%; height: auto;">
                    <div class="variation-description">
                        <h3><?php echo htmlspecialchars($texts['var4_title']); ?></h3>
                        <p><?php echo htmlspecialchars($texts['var4_desc']); ?></p>
                    </div>
                </div>
                <div class="variation-item">
                    <img src="lemonpics/Ginger Lemonade.jpg" alt="Ginger Lemonade" style="width: 80%; height: auto;">
                    <div class="variation-description">
                        <h3><?php echo htmlspecialchars($texts['var5_title']); ?></h3>
                        <p><?php echo htmlspecialchars($texts['var5_desc']); ?></p>
                    </div>
                </div>
            </div>
        </main>

        <aside class="func">
            <!-- User status module displays session information. -->
            <div class="user-status-module">
                <h4><?php echo htmlspecialchars($texts['status_title']); ?></h4>
                <p><?php echo htmlspecialchars($texts['status_user']); ?> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                <p><?php echo htmlspecialchars($texts['status_logintime']); ?> <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']); ?></p>
                <a href="logout.php" class="logout-btn"><?php echo htmlspecialchars($texts['status_logout_btn']); ?></a>
            </div>

            <!-- Language switcher is dynamically generated. -->
            <div class="language-switcher-module">
                <h4><?php echo htmlspecialchars($texts['lang_title']); ?></h4>
                <p><?php echo htmlspecialchars($texts['lang_current']); ?> <span id="current-lang-name"><?php echo $current_lang_name; ?></span></p>
                <div class="language-buttons">
                    <?php
                    foreach ($available_langs as $lang_code => $lang_name) {
                        if ($lang_code !== $current_lang_code) {
                            // Add class="lang-switch-btn" and data-lang attribute
                            echo '<a href="?lang=' . $lang_code . '" class="lang-btn lang-switch-btn" data-lang="' . $lang_code . '">' . $lang_name . '</a>';
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
    <script src="language_switcher.js"></script>
</body>
</html>
<?php
// --- 4. Cleanup ---
// Close the database connection to free up resources.
$conn->close();
?>
