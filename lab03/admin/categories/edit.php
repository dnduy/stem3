<?php
/**
 * LAB 03 – admin/categories/edit.php
 * Sửa thông tin chuyên mục
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$id  = (int)($_GET['id'] ?? 0);
$cat = get_category_by_id($id);

if (!$cat) {
    echo "<p style='padding:30px;color:red'>Không tìm thấy chuyên mục.</p>"; exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $slug = make_slug($name);

    if (empty($name)) {
        $error = 'Tên chuyên mục không được để trống.';
    } elseif (update_category($id, $name, $slug, $desc)) {
        redirect('index.php?msg=updated');
    } else {
        $error = 'Cập nhật thất bại – tên hoặc slug có thể đã tồn tại.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8"><title>Sửa Chuyên mục</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .navbar { background: #1F4E79; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #cde; text-decoration: none; margin-left: 14px; font-size: 14px; }
        .wrap { max-width: 520px; margin: 50px auto; background: #fff; padding: 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        h2 { color: #C55A11; margin-top: 0; }
        label { font-size: 13px; color: #555; display: block; margin: 12px 0 4px; }
        input, textarea { width: 100%; padding: 9px; box-sizing: border-box; border: 1px solid #bbb; border-radius: 5px; font-size: 14px; font-family: Arial; }
        textarea { resize: vertical; }
        .slug-info { font-size: 12px; color: #888; margin-top: 4px; }
        .actions { display: flex; gap: 10px; margin-top: 20px; }
        button { padding: 9px 22px; background: #C55A11; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        a.cancel { padding: 9px 22px; background: #eee; color: #333; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .err { background: #fce4d6; color: #C55A11; padding: 10px; border-radius: 5px; margin-bottom: 14px; font-size: 13px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị – Sửa Chuyên mục</strong>
    <a href="index.php">← Danh sách chuyên mục</a>
</div>
<div class="wrap">
    <h2>✏️ Sửa: <?= e($cat['name']) ?></h2>
    <?php if ($error): ?><div class="err"><?= e($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Tên chuyên mục <span style="color:red">*</span></label>
        <input type="text" name="name" value="<?= e($cat['name']) ?>" required>
        <div class="slug-info">Slug hiện tại: <code><?= e($cat['slug']) ?></code> (sẽ tự cập nhật khi đổi tên)</div>

        <label>Mô tả</label>
        <textarea name="description" rows="3"><?= e($cat['description'] ?? '') ?></textarea>

        <div class="actions">
            <button type="submit">💾 Lưu thay đổi</button>
            <a class="cancel" href="index.php">Hủy</a>
        </div>
    </form>
</div>
</body>
</html>
