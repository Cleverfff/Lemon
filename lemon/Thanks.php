<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\Thanks.php

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

// NOTE: No language switching logic here, as per requirements.
// The page will simply display based on the session language.

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

// Define which text groups we need for this page.
// Note: We only need 'thanks' as this page has no nav, footer, or func bar.
$page_keys = ['thanks']; 

// Include the translation loader
include __DIR__ . '/translations.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($texts['thanks_page_title'] ?? 'Acknowledgements'); ?></title>
    <link rel="stylesheet" type="text/css" href="Thanks.css">
</head>
<body>
    <div class="thanks-container">
        <h1><?php echo htmlspecialchars($texts['thanks_main_title']); ?></h1>
        
        <section class="thanks-section">
            <h2><?php echo htmlspecialchars($texts['thanks_images_title']); ?></h2>
            <ul>
                <li>
                    <strong><?php echo htmlspecialchars($texts['thanks_image1_credit']); ?></strong> 
                    <a href="https://bellyfull.net/homemade-lemonade-recipe/" target="_blank" rel="noopener noreferrer">bellyfull.net</a>
                </li>
                <!-- Add other image sources here -->
            </ul>
        </section>

        <section class="thanks-section">
            <h2><?php echo htmlspecialchars($texts['thanks_special_title']); ?></h2>
            <ul>
                <li><?php echo htmlspecialchars($texts['thanks_special1_text']); ?></li>
                <li><?php echo htmlspecialchars($texts['thanks_special2_text']); ?></li>
                <li><?php echo htmlspecialchars($texts['thanks_special3_text']); ?></li>
            </ul>
        </section>

        <a href="index.php" class="back-link"><?php echo htmlspecialchars($texts['thanks_back_link']); ?></a>
    </div>
</body>
</html>
<?php
$conn->close();
?>