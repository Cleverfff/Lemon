<?php
/**
 * File: register.php
 * Author: Pan Zitao
 * Date: 2025-07-22
 * Description: Handles server-side user registration.
 */

header('Content-Type: application/json');

// --- Database connection information ---
$servername = "localhost:3307";
$db_username = "root";
$db_password = "123456";
$dbname = "lemon";
$tableName = "users";
$usernameColumn = "username";
$passwordColumn = "password";

/**
 * Vigenère Decryption Function
 * This function is the inverse of the JavaScript encryption function.
 * It's needed to get the plain-text password for storage, as required by the login system.
 */
function vigenere_decrypt($ciphertext, $key) {
    $plaintext = "";
    $key_len = strlen($key);
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $cCharCode = ord($ciphertext[$i]);
        $kChar = $key[$i % $key_len];
        $shift = ord(strtolower($kChar)) - ord('a');

        $pCharCode;
        if ($cCharCode >= 97 && $cCharCode <= 122) { // a-z
            // The +26 ensures the result is always positive before the modulo
            $pCharCode = (($cCharCode - 97 - $shift + 26) % 26) + 97;
        } else if ($cCharCode >= 65 && $cCharCode <= 90) { // A-Z
            // The +26 ensures the result is always positive
            $pCharCode = (($cCharCode - 65 - $shift + 26) % 26) + 65;
        } else if ($cCharCode >= 48 && $cCharCode <= 57) { // 0-9
            // FINAL FIX: Using +20 (any multiple of 10 > shift) ensures the result is always positive.
            $pCharCode = (($cCharCode - 48 - $shift + 20) % 10) + 48;
        } else {
            $pCharCode = $cCharCode; // Do not decrypt other characters
        }
        $plaintext .= chr($pCharCode);
    }
    return $plaintext;
}

// --- Main Logic ---
$response = ['success' => false, 'message' => 'An unknown error occurred.'];

// Get the posted data
$data = json_decode(file_get_contents('php://input'));

if (!isset($data->username) || !isset($data->password)) {
    $response['message'] = 'Invalid input.';
    echo json_encode($response);
    exit();
}

$username_from_user = trim($data->username);
$encrypted_password_from_user = $data->password;

// Basic validation
if (empty($username_from_user) || empty($encrypted_password_from_user)) {
    $response['message'] = 'Username and password cannot be empty.';
    echo json_encode($response);
    exit();
}

// Create and check the database connection.
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    $response['message'] = 'Database connection failed.';
    echo json_encode($response);
    exit();
}
$conn->set_charset("utf8mb4");

// 1. Check if username already exists
$stmt = $conn->prepare("SELECT $usernameColumn FROM $tableName WHERE $usernameColumn = ?");
$stmt->bind_param("s", $username_from_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Username is already taken
    $response['message'] = 'This username is already taken. Please choose another one.';
} else {
    // 2. Username is available, proceed with registration
    // Decrypt the password to get the plain text for storage
    $key = "lemon";
    $plain_password_to_store = vigenere_decrypt($encrypted_password_from_user, $key);

    // 3. Insert the new user into the database
    $insert_stmt = $conn->prepare("INSERT INTO $tableName ($usernameColumn, $passwordColumn) VALUES (?, ?)");
    $insert_stmt->bind_param("ss", $username_from_user, $plain_password_to_store);
    
    if ($insert_stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Registration successful!';
    } else {
        $response['message'] = 'Registration failed. Please try again later.';
    }
    $insert_stmt->close();
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>