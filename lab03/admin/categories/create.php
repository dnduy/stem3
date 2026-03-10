<?php
/**
 * LAB 03 – admin/categories/create.php
 * Thêm chuyên mục mới
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $slug = make_slug($name);

    if (empty($name)) {
        $error = 'Tên chuyên mục không được để trống.';
    } elseif (empty($slug)) {
        $error = 'Tên chuyên mục không hợp lệ để tạo slug.';
    } elseif (create_category($name, $slug, $desc)) {
        redirect('index.php?msg=created');
    } else {
        $error = 'Tên hoặc slug đã tồn tại. Hãy dùng tên khác.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8"><title>Thêm Chuyên mục</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .navbar { background: #1F4E79; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #cde; text-decoration: none; margin-left: 14px; font-size: 14px; }
        .wrap { max-width: 520px; margin: 50px auto; background: #fff; padding: 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        h2 { color: #1F4E79; margin-top: 0; }
        label { font-size: 13px; color: #555; display: block; margin: 12px 0 4px; }
        input, textarea { width: 100%; padding: 9px; box-sizing: border-box; border: 1px solid #bbb; border-radius: 5px; font-size: 14px; font-family: Arial; }
        textarea { resize: vertical; }
        .hint { font-size: 12px; color: #888; margin-top: 4px; }
        .actions { display: flex; gap: 10px; margin-top: 20px; }
        button { padding: 9px 22px; background: #375623; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        a.cancel { padding: 9px 22px; background: #eee; color: #333; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .err { background: #fce4d6; color: #C55A11; padding: 10px; border-radius: 5px; margin-bottom: 14px; font-size: 13px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị – Thêm Chuyên mục</strong>
    <a href="index.php">← Danh sách chuyên mục</a>
</div>
<div class="wrap">
    <h2>🗂️ Thêm Chuyên mục mới</h2>
    <?php if ($error): ?><div class="err"><?= e($error) ?></div><?php endif; ?>
    <form method="POST">
        <label>Tên chuyên mục <span style="color:red">*</span></label>
        <input type="text" name="name" required placeholder="Vd: Công nghệ">
        <div class="hint">Slug sẽ tự động tạo từ tên. Vd: "Công nghệ" → cong-nghe</div>

        <label>Mô tả</label>
        <textarea name="description" rows="3" placeholder="Mô tả ngắn về chuyên mục..."></textarea>

        <div class="actions">
            <button type="submit">💾 Tạo chuyên mục</button>
            <a class="cancel" href="index.php">Hủy</a>
        </div>
    </form>
</div>
</body>
</html>
