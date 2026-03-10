<?php
/**
 * LAB 03 – admin/categories/index.php
 * Danh sách chuyên mục
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$categories = get_all_categories();
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Chuyên mục</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .navbar { background: #1F4E79; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #cde; text-decoration: none; margin-left: 14px; font-size: 14px; }
        .wrap { max-width: 900px; margin: 30px auto; padding: 0 16px; }
        h2 { color: #1F4E79; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
        th { background: #1F4E79; color: #fff; padding: 12px 14px; text-align: left; font-size: 13px; }
        td { padding: 10px 14px; font-size: 13px; border-bottom: 1px solid #eee; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f5f8fc; }
        .btn { padding: 4px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .btn-edit { background: #e8f0fe; color: #1a73e8; }
        .btn-del  { background: #fce8e6; color: #c00; }
        .add-btn  { display: inline-block; margin-bottom: 16px; padding: 9px 18px; background: #375623; color: #fff; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .msg-ok  { background: #e2efda; color: #375623; padding: 10px 16px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
        .msg-err { background: #fce4d6; color: #C55A11; padding: 10px 16px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
        .count-badge { background: #1F4E79; color: #fff; padding: 2px 8px; border-radius: 10px; font-size: 11px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị – Chuyên mục</strong>
    <div>
        <a href="../../news/index.php">📰 Xem trang tin tức</a>
        <a href="../../dashboard.php">🏠 Dashboard</a>
        <a href="../../logout.php">🚪 Đăng xuất</a>
    </div>
</div>

<div class="wrap">
    <h2>🗂️ Quản lý Chuyên mục</h2>

    <?php if ($msg === 'created'): ?><div class="msg-ok">✅ Tạo chuyên mục thành công!</div><?php endif; ?>
    <?php if ($msg === 'updated'): ?><div class="msg-ok">✅ Cập nhật thành công!</div><?php endif; ?>
    <?php if ($msg === 'deleted'): ?><div class="msg-ok">✅ Đã xóa chuyên mục.</div><?php endif; ?>
    <?php if ($msg === 'has_posts'): ?><div class="msg-err">❌ Không thể xóa – chuyên mục này còn bài viết bên trong!</div><?php endif; ?>

    <a class="add-btn" href="create.php">+ Thêm chuyên mục mới</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Tên chuyên mục</th>
            <th>Slug</th>
            <th>Mô tả</th>
            <th>Số bài viết</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= $cat['id'] ?></td>
            <td><strong><?= e($cat['name']) ?></strong></td>
            <td><code style="font-size:12px"><?= e($cat['slug']) ?></code></td>
            <td style="color:#666; font-size:12px"><?= e(excerpt($cat['description'] ?? '', 60)) ?></td>
            <td style="text-align:center">
                <span class="count-badge"><?= count_posts_in_category($cat['id']) ?></span>
            </td>
            <td>
                <a class="btn btn-edit" href="edit.php?id=<?= $cat['id'] ?>">✏️ Sửa</a>
                <a class="btn btn-del"  href="delete.php?id=<?= $cat['id'] ?>"
                   onclick="return confirm('Xóa chuyên mục «<?= e($cat['name']) ?>»?')">🗑️ Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
