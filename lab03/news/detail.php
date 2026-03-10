<?php
/**
 * LAB 03 – news/detail.php
 * Xem chi tiết một bài viết
 */
require_once '../functions.php';

$slug = $_GET['slug'] ?? '';
$post = get_post_by_slug($slug);

if (!$post) {
    echo "<p style='padding:40px;color:red'>Bài viết không tồn tại hoặc chưa được đăng.</p>";
    exit();
}

// Lấy bài viết liên quan (cùng chuyên mục, tối đa 3 bài)
$related = db_fetch_all(
    "SELECT id, title, slug, created_at FROM posts
     WHERE category_id = ? AND slug != ? AND status = 'published'
     ORDER BY created_at DESC LIMIT 3",
    'is', [$post['category_id'], $slug]
);

$categories = get_all_categories();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= e($post['title']) ?></title>
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
        .cat-nav a:hover { background: #FFD700; color: #1F4E79; border-color: #FFD700; font-weight: bold; }

        .container { max-width: 860px; margin: 30px auto; padding: 0 16px; }
        .breadcrumb { font-size: 13px; color: #888; margin-bottom: 16px; }
        .breadcrumb a { color: #1a73e8; text-decoration: none; }

        /* Article */
        .article { background: #fff; border-radius: 10px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .article-meta { font-size: 13px; color: #888; margin-bottom: 16px; }
        .article-meta .cat-tag { background: #e8f0fe; color: #1a73e8; padding: 3px 10px;
                                  border-radius: 10px; margin-right: 8px; text-decoration: none; font-weight: bold; }
        .article h1 { font-size: 26px; color: #1F4E79; line-height: 1.4; margin-bottom: 16px; }
        .article-body { font-size: 15px; line-height: 1.9; color: #333; border-top: 2px solid #f0f0f0; padding-top: 20px; }

        /* Related */
        .related { background: #fff; border-radius: 10px; padding: 24px; margin-top: 20px;
                   box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .related h3 { font-size: 16px; color: #1F4E79; margin-bottom: 14px;
                      border-left: 4px solid #FFD700; padding-left: 10px; }
        .related-item { padding: 8px 0; border-bottom: 1px solid #f0f0f0; font-size: 14px; }
        .related-item:last-child { border-bottom: none; }
        .related-item a { color: #1F4E79; text-decoration: none; }
        .related-item a:hover { text-decoration: underline; }
        .related-item small { color: #aaa; font-size: 12px; }
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
        <a href="category.php?slug=<?= e($c['slug']) ?>"><?= e($c['name']) ?></a>
    <?php endforeach; ?>
</div>

<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="index.php">Trang chủ</a> /
        <a href="category.php?slug=<?= e($post['cat_slug']) ?>"><?= e($post['cat_name']) ?></a> /
        <?= e(mb_substr($post['title'], 0, 40)) ?>...
    </div>

    <!-- Bài viết chính -->
    <div class="article">
        <div class="article-meta">
            <a class="cat-tag" href="category.php?slug=<?= e($post['cat_slug']) ?>">
                <?= e($post['cat_name']) ?>
            </a>
            ✍️ <?= e($post['author_name']) ?>
            &nbsp;|&nbsp;
            🕐 <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
            <?php if ($post['updated_at'] !== $post['created_at']): ?>
                &nbsp;|&nbsp; 🔄 Cập nhật: <?= date('d/m/Y H:i', strtotime($post['updated_at'])) ?>
            <?php endif; ?>
        </div>

        <h1><?= e($post['title']) ?></h1>

        <div class="article-body">
            <?= nl2br(e($post['content'])) ?>
        </div>
    </div>

    <!-- Bài viết liên quan -->
    <?php if (!empty($related)): ?>
    <div class="related">
        <h3>📌 Bài viết liên quan</h3>
        <?php foreach ($related as $r): ?>
        <div class="related-item">
            <a href="detail.php?slug=<?= e($r['slug']) ?>"><?= e($r['title']) ?></a><br>
            <small>🕐 <?= date('d/m/Y', strtotime($r['created_at'])) ?></small>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>
</body>
</html>
