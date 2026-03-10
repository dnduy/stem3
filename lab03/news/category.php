<?php
/**
 * LAB 03 – news/category.php
 * Hiển thị bài viết theo chuyên mục
 */
require_once '../functions.php';

$slug = $_GET['slug'] ?? '';
$cat  = get_category_by_slug($slug);

if (!$cat) {
    echo "<p style='padding:40px;color:red'>Chuyên mục không tồn tại.</p>";
    exit();
}

$posts      = get_posts_by_category($cat['id']);
$categories = get_all_categories();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chuyên mục: <?= e($cat['name']) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f6fa; color: #222; }
        .navbar { background: #1F4E79; padding: 14px 30px; display: flex; align-items: center; gap: 20px; }
        .navbar .brand { color: #FFD700; font-weight: bold; font-size: 20px; text-decoration: none; }
        .navbar a { color: #cde; text-decoration: none; font-size: 14px; }
        .navbar .right { margin-left: auto; }
        .cat-nav { background: #16375a; padding: 10px 30px; display: flex; gap: 6px; flex-wrap: wrap; }
        .cat-nav a { color: #aac8e8; text-decoration: none; font-size: 13px; padding: 4px 12px;
                     border-radius: 14px; border: 1px solid #2a5580; }
        .cat-nav a:hover, .cat-nav a.active { background: #FFD700; color: #1F4E79; border-color: #FFD700; font-weight: bold; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 16px; }
        .cat-header { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 20px;
                      border-left: 5px solid #FFD700; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .cat-header h1 { font-size: 22px; color: #1F4E79; }
        .cat-header p  { font-size: 14px; color: #666; margin-top: 6px; }
        .post-card { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 16px;
                     box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .post-meta { font-size: 12px; color: #888; margin-bottom: 8px; }
        .post-card h2 { font-size: 18px; margin-bottom: 8px; }
        .post-card h2 a { color: #1F4E79; text-decoration: none; }
        .post-card h2 a:hover { text-decoration: underline; }
        .post-card p { font-size: 14px; color: #555; line-height: 1.6; }
        .read-more { display: inline-block; margin-top: 10px; font-size: 13px; color: #1a73e8; text-decoration: none; }
        .back-link { display: inline-block; margin-bottom: 16px; font-size: 13px; color: #1a73e8; text-decoration: none; }
        .empty { text-align: center; color: #aaa; padding: 60px 0; font-size: 16px; }
    </style>
</head>
<body>

<div class="navbar">
    <a class="brand" href="index.php">📰 TinTức.vn</a>
    <div class="right">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="../dashboard.php">🏠 Dashboard</a> |
            <a href="../logout.php">🚪 Đăng xuất</a>
        <?php else: ?>
            <a href="../login.php">🔐 Đăng nhập</a>
        <?php endif; ?>
    </div>
</div>

<div class="cat-nav">
    <a href="index.php">Tất cả</a>
    <?php foreach ($categories as $c): ?>
        <a href="category.php?slug=<?= e($c['slug']) ?>"
           class="<?= $c['id'] === $cat['id'] ? 'active' : '' ?>">
            <?= e($c['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="container">
    <a class="back-link" href="index.php">← Tất cả tin tức</a>

    <div class="cat-header">
        <h1>🗂️ <?= e($cat['name']) ?></h1>
        <?php if ($cat['description']): ?>
            <p><?= e($cat['description']) ?></p>
        <?php endif; ?>
    </div>

    <?php if (empty($posts)): ?>
        <div class="empty">Chuyên mục này chưa có bài viết nào được đăng.</div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-meta">
                ✍️ <?= e($post['author_name']) ?> &nbsp;|&nbsp;
                🕐 <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
            </div>
            <h2><a href="detail.php?slug=<?= e($post['slug']) ?>"><?= e($post['title']) ?></a></h2>
            <p><?= e(excerpt($post['content'], 160)) ?></p>
            <a class="read-more" href="detail.php?slug=<?= e($post['slug']) ?>">Đọc tiếp →</a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
