<?php
/**
 * File: translations.php
 * Author: Pan Zitao
 * Date: 2025-07-21
 * Description: Loads text translations for the Lemonade Guide website.
 */

/**
 * Translation Loader
 * 
 * This script connects to the database and fetches all necessary text translations
 * for the specified page keys in the currently selected language.
 * 
 * It expects two variables to be set before it's included:
 * 1. $conn: An active database connection object.
 * 2. $page_keys: An array of 'page_key' strings to fetch from the database.
 * 
 * It produces one variable:
 * 1. $texts: An associative array where keys are 'text_key' and values are the translated strings.
 */

// Ensure required variables are set
if (!isset($conn) || !isset($page_keys) || !isset($current_lang_code)) {
    die("Error: Required variables for translation loader are not set.");
}

// The array to hold our translated texts
$texts = [];

// Create a string of placeholders for the IN clause (e.g., '?, ?, ?')
$placeholders = implode(',', array_fill(0, count($page_keys), '?'));

// Prepare the SQL statement to fetch all relevant texts at once
// We select the text_key and the column corresponding to the current language
$sql = "SELECT text_key, `$current_lang_code` FROM translations WHERE page_key IN ($placeholders)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Dynamically bind the page_key parameters
    // 's' is repeated for each key in $page_keys
    $types = str_repeat('s', count($page_keys));
    $stmt->bind_param($types, ...$page_keys);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Populate the $texts array
    while ($row = $result->fetch_assoc()) {
        // The key is the 'text_key', the value is the text from the language column (e.g., 'en', 'zh')
        $texts[$row['text_key']] = $row[$current_lang_code];
    }

    $stmt->close();
}
?>