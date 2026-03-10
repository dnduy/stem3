<?php
/**
 * LAB 02 – process_register.php
 * Xử lý đăng ký tài khoản mới
 */
session_start();
require "../db.php";

// ── Bước 1: Lấy và làm sạch dữ liệu ──────────────────────
$full_name = trim($_POST['full_name'] ?? '');
$username  = trim($_POST['username']  ?? '');
$email     = trim($_POST['email']     ?? '');
$password  = $_POST['password']  ?? '';
$password2 = $_POST['password2'] ?? '';

// ── Bước 2: Validate ──────────────────────────────────────
if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
    header("Location: register.php?error=Vui+lòng+điền+đầy+đủ+thông+tin");
    exit();
}

if ($password !== $password2) {
    header("Location: register.php?error=Mật+khẩu+nhập+lại+không+khớp");
    exit();
}

if (strlen($password) < 6) {
    header("Location: register.php?error=Mật+khẩu+phải+có+ít+nhất+6+ký+tự");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: register.php?error=Email+không+hợp+lệ");
    exit();
}

// ── Bước 3: Kiểm tra username / email đã tồn tại ──────────
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    header("Location: register.php?error=Username+hoặc+Email+đã+tồn+tại");
    exit();
}
$stmt->close();

// ── Bước 4: Mã hóa mật khẩu ───────────────────────────────
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// ── Bước 5: Lưu vào CSDL ──────────────────────────────────
$stmt = $conn->prepare(
    "INSERT INTO users (username, password, full_name, email) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $username, $hashed_password, $full_name, $email);

if ($stmt->execute()) {
    header("Location: login.php?success=Đăng+ký+thành+công!+Hãy+đăng+nhập");
} else {
    header("Location: register.php?error=Có+lỗi+xảy+ra,+vui+lòng+thử+lại");
}
$stmt->close();
exit();
