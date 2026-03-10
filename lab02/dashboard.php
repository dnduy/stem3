<?php
/**
 * LAB 02 – dashboard.php
 * Trang chính sau khi đăng nhập (Lab 02 & 03 dùng chung)
 */
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$is_admin = ($user['role'] === 'admin');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f4f8; margin:0; padding:0; }
        .navbar { background:#1F4E79; color:#fff; padding:14px 30px; display:flex; justify-content:space-between; align-items:center; }
        .navbar a { color:#fff; text-decoration:none; margin-left:16px; font-size:14px; }
        .navbar a:hover { text-decoration:underline; }
        .content { max-width:720px; margin:50px auto; }
        .card { background:#fff; border-radius:10px; padding:30px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        h2 { color:#1F4E79; margin-top:0; }
        .badge { display:inline-block; padding:3px 12px; border-radius:12px; font-size:12px;
                 background:<?= $is_admin ? '#C55A11' : '#375623' ?>; color:#fff; margin-left:8px; }
        .menu-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:24px; }
        .menu-item { background:#f0f4f8; border:1px solid #dde3ea; border-radius:8px;
                     padding:18px; text-align:center; text-decoration:none; color:#1F4E79; font-weight:bold; }
        .menu-item:hover { background:#dde3ea; }
    </style>
</head>
<body>
<div class="navbar">
    <span>🏠 Hệ thống Quản lý</span>
    <div>
        <?php if ($is_admin): ?>
            <a href="admin/index.php">⚙️ Quản trị</a>
        <?php endif; ?>
        <a href="news/index.php">📰 Xem tin tức</a>
        <a href="logout.php">🚪 Đăng xuất</a>
    </div>
</div>

<div class="content">
    <div class="card">
        <h2>Xin chào, <?= htmlspecialchars($user['full_name']) ?>
            <span class="badge"><?= $user['role'] ?></span>
        </h2>
        <p>Bạn đã đăng nhập thành công vào hệ thống.</p>
        <p>Username: <code><?= htmlspecialchars($user['username']) ?></code></p>

        <div class="menu-grid">
            <a class="menu-item" href="news/index.php">📰 Đọc tin tức</a>
            <?php if ($is_admin): ?>
                <a class="menu-item" href="admin/categories/index.php">🗂️ Quản lý chuyên mục</a>
                <a class="menu-item" href="admin/posts/index.php">📝 Quản lý bài viết</a>
                <a class="menu-item" href="admin/index.php">👥 Quản lý người dùng</a>
            <?php endif; ?>
            <a class="menu-item" href="logout.php">🚪 Đăng xuất</a>
        </div>
    </div>
</div>
</body>
</html>
