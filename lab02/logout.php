<?php
/**
 * logout.php – Đăng xuất, hủy session
 */
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
