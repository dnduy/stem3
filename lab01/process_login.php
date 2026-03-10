<?php
/**
 * LAB 01 – process_login.php
 * Xử lý logic đăng nhập (Lab 01: dùng plain-text, chưa có hash)
 *
 * NOTE: Lab 02 sẽ nâng cấp file này để dùng password_verify()
 *       và Prepared Statement thay cho SQL ghép chuỗi.
 */
session_start();
require "../db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// ⚠️  Lab 01: SQL ghép chuỗi trực tiếp – dễ bị SQL Injection
//     (Lab 02 sẽ sửa bằng Prepared Statement)
$sql    = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);

    $_SESSION['user'] = [
        "id"        => $user["id"],
        "username"  => $user["username"],
        "full_name" => $user["full_name"],
        "role"      => $user["role"] ?? 'user',
    ];

    header("Location: dashboard.php");
    exit();
} else {
    header("Location: login.php?error=Sai+username+hoặc+mật+khẩu!");
    exit();
}
