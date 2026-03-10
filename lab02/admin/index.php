<?php
/**
 * LAB 02 – admin/index.php
 * Quản lý danh sách người dùng
 */
session_start();
require "../db.php";

// Chỉ admin mới được vào
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$msg = $_GET['msg'] ?? '';

$stmt   = $conn->prepare(
    "SELECT id, username, full_name, email, role, created_at FROM users ORDER BY id"
);
$stmt->execute();
$users  = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f4f8; margin:0; }
        .navbar { background:#1F4E79; color:#fff; padding:12px 24px; display:flex; justify-content:space-between; }
        .navbar a { color:#fff; text-decoration:none; margin-left:14px; }
        .wrap { max-width:960px; margin:30px auto; padding:0 16px; }
        h2 { color:#1F4E79; }
        table { width:100%; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,.08); }
        th { background:#1F4E79; color:#fff; padding:12px 10px; text-align:left; font-size:13px; }
        td { padding:10px; font-size:13px; border-bottom:1px solid #eee; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#f5f8fc; }
        .badge { padding:2px 9px; border-radius:10px; font-size:11px; color:#fff;
                 background: var(--bg); }
        .btn { padding:4px 10px; border-radius:4px; text-decoration:none; font-size:12px; }
        .btn-edit { background:#e8f0fe; color:#1a73e8; }
        .btn-del  { background:#fce8e6; color:#c00; }
        .add-btn  { display:inline-block; margin-bottom:14px; padding:8px 16px; background:#375623;
                    color:#fff; text-decoration:none; border-radius:6px; font-size:14px; }
        .msg-ok  { background:#e2efda; color:#375623; padding:10px; border-radius:6px; margin-bottom:14px; }
        .msg-err { background:#fce4d6; color:#C55A11; padding:10px; border-radius:6px; margin-bottom:14px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị hệ thống</strong>
    <div>
        <a href="../dashboard.php">🏠 Dashboard</a>
        <a href="../logout.php">🚪 Đăng xuất</a>
    </div>
</div>

<div class="wrap">
    <h2>👥 Quản lý Người dùng</h2>

    <?php if ($msg === 'deleted'): ?>
        <div class="msg-ok">✅ Đã xóa người dùng.</div>
    <?php elseif ($msg === 'self'): ?>
        <div class="msg-err">❌ Không thể tự xóa tài khoản đang đăng nhập!</div>
    <?php endif; ?>

    <a class="add-btn" href="../register.php">+ Tạo tài khoản mới</a>

    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Họ tên</th>
            <th>Email</th><th>Role</th><th>Ngày tạo</th><th>Thao tác</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['full_name']) ?></td>
            <td><?= htmlspecialchars($u['email'] ?? '') ?></td>
            <td>
                <span class="badge" style="--bg:<?= $u['role']==='admin' ? '#C55A11' : '#375623' ?>">
                    <?= $u['role'] ?>
                </span>
            </td>
            <td><?= $u['created_at'] ?></td>
            <td>
                <a class="btn btn-edit" href="edit.php?id=<?= $u['id'] ?>">Sửa</a>
                <a class="btn btn-del"  href="delete.php?id=<?= $u['id'] ?>"
                   onclick="return confirm('Xác nhận xóa người dùng này?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
