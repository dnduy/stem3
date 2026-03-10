<?php
/**
 * LAB 03 – admin/posts/index.php
 * Danh sách bài viết
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$posts = get_all_posts();
$msg   = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8"><title>Quản lý Bài viết</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .navbar { background: #1F4E79; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #cde; text-decoration: none; margin-left: 14px; font-size: 14px; }
        .wrap { max-width: 1100px; margin: 30px auto; padding: 0 16px; }
        h2 { color: #1F4E79; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
        th { background: #1F4E79; color: #fff; padding: 11px 12px; text-align: left; font-size: 13px; }
        td { padding: 10px 12px; font-size: 13px; border-bottom: 1px solid #eee; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f5f8fc; }
        .status-pub  { background: #e2efda; color: #375623; padding: 2px 9px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .status-dft  { background: #fce4d6; color: #C55A11; padding: 2px 9px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .cat-tag { background: #e8f0fe; color: #1a73e8; padding: 2px 8px; border-radius: 10px; font-size: 11px; }
        .btn { padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .btn-edit { background: #e8f0fe; color: #1a73e8; }
        .btn-view { background: #e2efda; color: #375623; }
        .btn-del  { background: #fce8e6; color: #c00; }
        .add-btn  { display: inline-block; margin-bottom: 16px; padding: 9px 18px; background: #375623; color: #fff; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .msg-ok  { background: #e2efda; color: #375623; padding: 10px 16px; border-radius: 6px; margin-bottom: 14px; font-size: 14px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị – Bài viết</strong>
    <div>
        <a href="../categories/index.php">🗂️ Chuyên mục</a>
        <a href="../../news/index.php">📰 Xem trang tin tức</a>
        <a href="../../dashboard.php">🏠 Dashboard</a>
        <a href="../../logout.php">🚪 Đăng xuất</a>
    </div>
</div>

<div class="wrap">
    <h2>📝 Quản lý Bài viết</h2>

    <?php if ($msg === 'created'): ?><div class="msg-ok">✅ Tạo bài viết thành công!</div><?php endif; ?>
    <?php if ($msg === 'updated'): ?><div class="msg-ok">✅ Cập nhật bài viết thành công!</div><?php endif; ?>
    <?php if ($msg === 'deleted'): ?><div class="msg-ok">✅ Đã xóa bài viết.</div><?php endif; ?>

    <a class="add-btn" href="create.php">+ Viết bài mới</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Chuyên mục</th>
            <th>Tác giả</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= $post['id'] ?></td>
            <td style="max-width:280px">
                <strong><?= e(mb_substr($post['title'], 0, 55)) ?><?= mb_strlen($post['title']) > 55 ? '...' : '' ?></strong>
            </td>
            <td><span class="cat-tag"><?= e($post['cat_name']) ?></span></td>
            <td><?= e($post['author_name']) ?></td>
            <td>
                <?php if ($post['status'] === 'published'): ?>
                    <span class="status-pub">✅ Đã đăng</span>
                <?php else: ?>
                    <span class="status-dft">📝 Nháp</span>
                <?php endif; ?>
            </td>
            <td style="font-size:12px; color:#888"><?= date('d/m/Y', strtotime($post['created_at'])) ?></td>
            <td style="white-space:nowrap">
                <?php if ($post['status'] === 'published'): ?>
                    <a class="btn btn-view" href="../../news/detail.php?slug=<?= e($post['slug']) ?>" target="_blank">👁️ Xem</a>
                <?php endif; ?>
                <a class="btn btn-edit" href="edit.php?id=<?= $post['id'] ?>">✏️ Sửa</a>
                <a class="btn btn-del"  href="delete.php?id=<?= $post['id'] ?>"
                   onclick="return confirm('Xóa bài «<?= e(mb_substr($post['title'],0,30)) ?>...»?')">🗑️ Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
