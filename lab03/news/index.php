<?php
/**
 * LAB 03 – news/index.php
 * Trang chủ tin tức (công khai, không cần đăng nhập)
 */
require_once '../functions.php';

$categories = get_all_categories();
$posts      = get_published_posts();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin Tức</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f6fa; color: #222; }

        /* Navbar */
        .navbar { background: #1F4E79; padding: 14px 30px; display: flex; align-items: center; gap: 20px; }
        .navbar .brand { color: #FFD700; font-weight: bold; font-size: 20px; text-decoration: none; }
        .navbar a { color: #cde; text-decoration: none; font-size: 14px; }
        .navbar a:hover { color: #fff; }
        .navbar .right { margin-left: auto; }

        /* Category nav */
        .cat-nav { background: #16375a; padding: 10px 30px; display: flex; gap: 6px; flex-wrap: wrap; }
        .cat-nav a { color: #aac8e8; text-decoration: none; font-size: 13px; padding: 4px 12px;
                     border-radius: 14px; border: 1px solid #2a5580; }
        .cat-nav a:hover, .cat-nav a.active { background: #FFD700; color: #1F4E79; border-color: #FFD700; font-weight: bold; }

        /* Layout */
        .container { max-width: 900px; margin: 30px auto; padding: 0 16px; }
        h1 { font-size: 22px; color: #1F4E79; margin-bottom: 20px; border-left: 4px solid #FFD700; padding-left: 12px; }

        /* Post card */
        .post-card { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 16px;
                     box-shadow: 0 1px 4px rgba(0,0,0,.08); transition: box-shadow .2s; }
        .post-card:hover { box-shadow: 0 3px 12px rgba(0,0,0,.13); }
        .post-meta { font-size: 12px; color: #888; margin-bottom: 8px; }
        .post-meta .cat-tag { background: #e8f0fe; color: #1a73e8; padding: 2px 8px;
                              border-radius: 10px; margin-right: 8px; text-decoration: none; font-weight: bold; }
        .post-card h2 { font-size: 18px; margin-bottom: 8px; }
        .post-card h2 a { color: #1F4E79; text-decoration: none; }
        .post-card h2 a:hover { text-decoration: underline; }
        .post-card p { font-size: 14px; color: #555; line-height: 1.6; }
        .read-more { display: inline-block; margin-top: 10px; font-size: 13px;
                     color: #1a73e8; text-decoration: none; }
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
    <a href="index.php" class="active">Tất cả</a>
    <?php foreach ($categories as $cat): ?>
        <a href="category.php?slug=<?= e($cat['slug']) ?>"><?= e($cat['name']) ?></a>
    <?php endforeach; ?>
</div>

<div class="container">
    <h1>📰 Tin tức mới nhất</h1>

    <?php if (empty($posts)): ?>
        <div class="empty">Chưa có bài viết nào được đăng.</div>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
        <div class="post-card">
            <div class="post-meta">
                <a class="cat-tag" href="category.php?slug=<?= e($post['cat_slug']) ?>">
                    <?= e($post['cat_name']) ?>
                </a>
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
