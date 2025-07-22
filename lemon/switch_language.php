<?php
/**
 * File: switch_language.php
 * Author: Pan Zitao
 * Date: 2025-07-22
 * Description: Handles AJAX requests to switch the language.
 */

header('Content-Type: application/json');
session_start();

$available_langs = ['en' => 'English', 'zh' => '中文', 'de' => 'Deutsch'];
$response = ['success' => false];
$data = json_decode(file_get_contents('php://input'), true);

// Check if the requested language is valid
if (isset($data['lang']) && array_key_exists($data['lang'], $available_langs)) {
    // Update the session language
    $_SESSION['lang'] = $data['lang'];
    $response['success'] = true;
}

echo json_encode($response);
?>