<?php
/**
 * LAB 03 – admin/categories/delete.php
 * Xóa chuyên mục (không cho xóa nếu còn bài viết)
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$id = (int)($_GET['id'] ?? 0);

if (count_posts_in_category($id) > 0) {
    redirect('index.php?msg=has_posts');
}

delete_category($id);
redirect('index.php?msg=deleted');
