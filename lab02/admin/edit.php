<?php
/**
 * LAB 02 – admin/edit.php
 * Sửa thông tin người dùng (admin mới được dùng)
 */
session_start();
require "../db.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$id = (int)($_GET['id'] ?? 0);

// Xử lý submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email     = trim($_POST['email']     ?? '');
    $role      = $_POST['role'] === 'admin' ? 'admin' : 'user';

    $stmt = $conn->prepare(
        "UPDATE users SET full_name = ?, email = ?, role = ? WHERE id = ?"
    );
    $stmt->bind_param("sssi", $full_name, $email, $role, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?msg=updated");
    exit();
}

// Lấy thông tin user cần sửa
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    echo "Không tìm thấy người dùng.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa người dùng</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f4f8; margin:0; }
        .wrap { max-width:480px; margin:60px auto; background:#fff; padding:32px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,.08); }
        h2 { color:#1F4E79; margin-top:0; }
        label { font-size:13px; color:#555; display:block; margin-bottom:4px; margin-top:12px; }
        input, select { width:100%; padding:9px; box-sizing:border-box; border:1px solid #bbb; border-radius:5px; font-size:14px; }
        .actions { margin-top:20px; display:flex; gap:10px; }
        button { padding:9px 20px; background:#1F4E79; color:#fff; border:none; border-radius:5px; cursor:pointer; font-size:14px; }
        a.cancel { padding:9px 20px; background:#eee; color:#333; text-decoration:none; border-radius:5px; font-size:14px; }
    </style>
</head>
<body>
<div class="wrap">
    <h2>✏️ Sửa người dùng: <?= htmlspecialchars($user['username']) ?></h2>
    <form method="POST">
        <label>Họ và tên</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">

        <label>Role (phân quyền)</label>
        <select name="role">
            <option value="user"  <?= $user['role'] === 'user'  ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>

        <div class="actions">
            <button type="submit">💾 Lưu thay đổi</button>
            <a class="cancel" href="index.php">Hủy</a>
        </div>
    </form>
</div>
</body>
</html>
