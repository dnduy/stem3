<?php
/**
 * LAB 02 – login.php
 * Form đăng nhập (dùng chung cho cả Lab 02 và 03)
 */
session_start();

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
    <title>Đăng nhập</title>
    <style>
        body { font-family: Arial, sans-serif; display:flex; justify-content:center; margin-top:80px; background:#f5f5f5; }
        .box { background:#fff; border:1px solid #ddd; padding:36px; border-radius:10px; width:340px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        h2   { text-align:center; color:#1F4E79; margin-bottom:20px; }
        label{ font-size:13px; color:#555; }
        input{ width:100%; padding:9px; margin:4px 0 14px; box-sizing:border-box; border:1px solid #bbb; border-radius:5px; font-size:14px; }
        button { width:100%; padding:10px; background:#1F4E79; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:15px; }
        button:hover { background:#16375a; }
        .err { color:#c00; font-size:13px; background:#fff0f0; padding:8px; border-radius:4px; margin-bottom:10px; }
        .ok  { color:#375623; font-size:13px; background:#e2efda; padding:8px; border-radius:4px; margin-bottom:10px; }
        .links { text-align:center; margin-top:14px; font-size:13px; }
    </style>
</head>
<body>
<div class="box">
    <h2>🔐 Đăng nhập</h2>

    <?php if ($error):   ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="ok"><?= htmlspecialchars($success) ?></div><?php endif; ?>

    <form action="process_login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required autofocus>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Đăng nhập</button>
    </form>

    <div class="links">
        Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a>
    </div>
</div>
</body>
</html>
