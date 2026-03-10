<?php
/**
 * LAB 03 – admin/posts/create.php
 * Viết bài mới
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$categories = get_all_categories();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_id  = (int)($_POST['category_id'] ?? 0);
    $title   = trim($_POST['title']   ?? '');
    $content = trim($_POST['content'] ?? '');
    $status  = ($_POST['status'] ?? '') === 'published' ? 'published' : 'draft';
    $slug    = make_slug($title);
    $author  = (int)$_SESSION['user']['id'];

    if (empty($title) || empty($content) || $cat_id === 0) {
        $error = 'Vui lòng điền đầy đủ tiêu đề, nội dung và chọn chuyên mục.';
    } elseif (create_post($cat_id, $title, $slug, $content, $status, $author)) {
        redirect('index.php?msg=created');
    } else {
        $error = 'Tạo bài thất bại – tiêu đề có thể đã tồn tại. Hãy đổi tiêu đề khác.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8"><title>Viết bài mới</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .navbar { background: #1F4E79; color: #fff; padding: 12px 24px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: #cde; text-decoration: none; margin-left: 14px; font-size: 14px; }
        .wrap { max-width: 760px; margin: 30px auto; background: #fff; padding: 32px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        h2 { color: #375623; margin-top: 0; }
        label { font-size: 13px; color: #555; display: block; margin: 14px 0 4px; font-weight: bold; }
        input[type=text], select, textarea { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #bbb; border-radius: 5px; font-size: 14px; font-family: Arial; }
        textarea { resize: vertical; }
        .row2 { display: flex; gap: 16px; }
        .row2 > div { flex: 1; }
        .hint { font-size: 12px; color: #888; margin-top: 4px; }
        .actions { display: flex; gap: 12px; margin-top: 24px; }
        button { padding: 10px 24px; background: #375623; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        a.cancel { padding: 10px 24px; background: #eee; color: #333; text-decoration: none; border-radius: 5px; font-size: 14px; }
        .err { background: #fce4d6; color: #C55A11; padding: 10px; border-radius: 5px; margin-bottom: 16px; font-size: 13px; }
    </style>
</head>
<body>
<div class="navbar">
    <strong>⚙️ Quản trị – Viết bài mới</strong>
    <a href="index.php">← Danh sách bài viết</a>
</div>

<div class="wrap">
    <h2>📝 Viết bài mới</h2>
    <?php if ($error): ?><div class="err"><?= e($error) ?></div><?php endif; ?>

    <form method="POST">
        <label>Tiêu đề bài viết <span style="color:red">*</span></label>
        <input type="text" name="title" required placeholder="Nhập tiêu đề bài viết...">
        <div class="hint">Slug URL sẽ được tự tạo từ tiêu đề.</div>

        <div class="row2">
            <div>
                <label>Chuyên mục <span style="color:red">*</span></label>
                <select name="category_id" required>
                    <option value="">-- Chọn chuyên mục --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Trạng thái</label>
                <select name="status">
                    <option value="draft">📝 Lưu nháp</option>
                    <option value="published">✅ Đăng ngay</option>
                </select>
            </div>
        </div>

        <label>Nội dung bài viết <span style="color:red">*</span></label>
        <textarea name="content" rows="14" required placeholder="Nhập nội dung bài viết..."></textarea>

        <div class="actions">
            <button type="submit">💾 Lưu bài viết</button>
            <a class="cancel" href="index.php">Hủy</a>
        </div>
    </form>
</div>
</body>
</html>
