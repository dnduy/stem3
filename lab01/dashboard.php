<?php
/**
 * LAB 01 – dashboard.php
 * Trang sau khi đăng nhập thành công
 */
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard – Lab 01</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        .card{ border:1px solid #ccc; padding:24px; border-radius:8px; max-width:480px; }
        h2  { color:#1F4E79; }
        .badge { display:inline-block; padding:3px 10px; border-radius:12px; font-size:12px;
                 background:#1F4E79; color:#fff; margin-left:8px; }
    </style>
</head>
<body>
<div class="card">
    <h2>✅ Đăng nhập thành công!</h2>
    <p>Xin chào, <strong><?= htmlspecialchars($user['full_name']) ?></strong>
       <span class="badge"><?= $user['role'] ?></span>
    </p>
    <p>Username: <code><?= htmlspecialchars($user['username']) ?></code></p>
    <p>ID người dùng: <code><?= $user['id'] ?></code></p>
    <hr>
    <a href="logout.php">🚪 Đăng xuất</a>
</div>
</body>
</html>
