<?php
/**
 * LAB 03 – admin/posts/delete.php
 * Xóa bài viết
 */
session_start();
require_once '../../functions.php';
require_admin('../../');

$id = (int)($_GET['id'] ?? 0);
delete_post($id);
redirect('index.php?msg=deleted');
