<?php
/**
 * LAB 01 – logout.php
 * Hủy session và chuyển về trang đăng nhập
 */
session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit();
