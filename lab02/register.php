<?php
/**
 * LAB 02 – register.php
 * Form đăng ký tài khoản mới
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
    <title>Đăng ký tài khoản</title>
    <style>
        body { font-family: Arial, sans-serif; display:flex; justify-content:center; margin-top:60px; background:#f5f5f5; }
        .box { background:#fff; border:1px solid #ddd; padding:36px; border-radius:10px; width:360px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        h2   { text-align:center; color:#1F4E79; }
        label{ font-size:13px; color:#555; }
        input{ width:100%; padding:9px; margin:4px 0 12px; box-sizing:border-box; border:1px solid #bbb; border-radius:5px; font-size:14px; }
        button { width:100%; padding:10px; background:#375623; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:15px; }
        button:hover { background:#254018; }
        .err { color:#c00; font-size:13px; background:#fff0f0; padding:8px; border-radius:4px; margin-bottom:10px; }
        .links { text-align:center; margin-top:14px; font-size:13px; }
    </style>
</head>
<body>
<div class="box">
    <h2>📝 Đăng ký</h2>

    <?php if ($error): ?><div class="err"><?= htmlspecialchars($error) ?></div><?php endif; ?>

    <form action="process_register.php" method="POST">
        <label>Họ và tên</label>
        <input type="text" name="full_name" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Mật khẩu</label>
        <input type="password" name="password" required>

        <label>Nhập lại mật khẩu</label>
        <input type="password" name="password2" required>

        <button type="submit">Tạo tài khoản</button>
    </form>

    <div class="links">
        Đã có tài khoản? <a href="login.php">Đăng nhập</a>
    </div>
</div>
</body>
</html>
