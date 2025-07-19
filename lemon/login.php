<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\login.php

// --- 数据库连接信息 (请根据您的 XAMPP 配置修改) ---
$servername = "localhost:3307";
$db_username = "root";
$db_password = "123456";
$dbname = "lemon";

// --- 表和字段信息 (如果不同，请修改) ---
$tableName = "users";
$usernameColumn = "username";
$passwordColumn = "password"; // !! 重要：数据库中应存储未加密的原始密码

// 设置响应头为 JSON
header('Content-Type: application/json');

// 创建数据库连接
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// 检查连接
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// 获取从前端发送的 JSON 数据
$json_data = file_get_contents('php://input');
$data = json_decode($json_data);

// 检查数据是否存在
if (!isset($data->username) || !isset($data->password)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit();
}

$username_from_user = $data->username;
$encrypted_password_from_user = $data->password;

// 使用预处理语句防止 SQL 注入
$stmt = $conn->prepare("SELECT $passwordColumn FROM $tableName WHERE $usernameColumn = ?");
$stmt->bind_param("s", $username_from_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $plain_password_from_db = $row[$passwordColumn];

    // 在服务器端用同样的凯撒密码加密从数据库取出的原始密码
    $shift = 3;
    $encrypted_password_from_db = "";
    for ($i = 0; $i < strlen($plain_password_from_db); $i++) {
        $charCode = ord($plain_password_from_db[$i]);
        if ($charCode >= 97 && $charCode <= 122) { // a-z
            $charCode = (($charCode - 97 + $shift) % 26) + 97;
        } else if ($charCode >= 65 && $charCode <= 90) { // A-Z
            $charCode = (($charCode - 65 + $shift) % 26) + 65;
        }
        $encrypted_password_from_db .= chr($charCode);
    }

    // 比较前端传来的加密密码和后端生成的加密密码
    if ($encrypted_password_from_user === $encrypted_password_from_db) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Incorrect password.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
}

$stmt->close();
$conn->close();

?>