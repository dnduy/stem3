<?php
/**
 * LAB 02 – process_login.php
 * Xử lý đăng nhập:
 *   ✅ Prepared Statement  → chống SQL Injection
 *   ✅ password_verify()   → kiểm tra mật khẩu đã hash
 */
session_start();
require "../db.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Bước 1: Lấy user theo username (KHÔNG ghép password vào SQL)
$stmt = $conn->prepare(
    "SELECT id, username, password, full_name, role FROM users WHERE username = ?"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Bước 2: Kiểm tra mật khẩu với hash
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            "id"        => $user["id"],
            "username"  => $user["username"],
            "full_name" => $user["full_name"],
            "role"      => $user["role"],
        ];
        header("Location: dashboard.php");
        exit();
    }
}

$stmt->close();
header("Location: login.php?error=Sai+username+hoặc+mật+khẩu!");
exit();
