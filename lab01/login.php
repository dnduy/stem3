<?php
/**
 * LAB 01 – login.php
 * Trang đăng nhập – hiển thị form
 */
session_start();

// Nếu đã đăng nhập rồi thì chuyển thẳng vào dashboard
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}

$error   = $_GET['error']   ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập – Lab 01</title>
    <style>
        body { font-family: Arial, sans-serif; display:flex; justify-content:center; margin-top:80px; }
        .box { border: 1px solid #ccc; padding: 32px; border-radius:8px; width:320px; }
        h2   { text-align:center; color:#1F4E79; }
        input{ width:100%; padding:8px; margin:6px 0 14px; box-sizing:border-box; border:1px solid #aaa; border-radius:4px; }
        button { width:100%; padding:10px; background:#1F4E79; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:15px; }
        .err { color:red; font-size:13px; }
        .ok  { color:green; font-size:13px; }
        .link{ text-align:center; margin-top:12px; font-size:13px; }
    </style>
</head>
<body>
<div class="box">
    <h2>🔐 Đăng nhập</h2>

    <?php if ($error):   ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="ok"><?= htmlspecialchars($success) ?></p><?php endif; ?>

    <form action="process_login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required autofocus>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Đăng nhập</button>
    </form>

    <div class="link">
        Chưa có tài khoản? <a href="register.php">Đăng ký</a>
    </div>
</div>
</body>
</html>
